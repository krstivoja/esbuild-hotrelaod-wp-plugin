const esbuild = require('esbuild');
const WebSocket = require('ws');
const browserSync = require('browser-sync').create();
const os = require('os');
require('dotenv').config();

const isWatch = process.argv.includes('--watch');

const proxyUrl = process.env.PROXY_URL;

// WebSocket server for hot reload
let wss;
if (isWatch) {
    const wsPort = 8080; // Change this to your desired port
    const wsHost = os.hostname(); // Get the hostname of the machine
    const wsUrl = `ws://${proxyUrl}:${wsPort}`; // Set WebSocket URL based on the hostname
    wss = new WebSocket.Server({ port: wsPort });
    console.log(`WebSocket server running on ${wsUrl}`);
}

// Build function
const build = async () => {
    const buildOptions = {
        entryPoints: ['src/index.js'],
        bundle: true,
        outfile: 'dist/bundle.js',
        sourcemap: true,
        plugins: [
            {
                name: 'css-hot-reload',
                setup(build) {
                    build.onEnd(() => {
                        wss.clients.forEach((client) => {
                            if (client.readyState === WebSocket.OPEN) {
                                client.send('reload');
                            }
                        });
                    });
                }
            }
        ]
    };

    if (isWatch) {
        // Use esbuild's context API for watch mode
        const context = await esbuild.context(buildOptions);

        // Start watching for changes
        await context.watch();
        console.log('Watching for changes...');

        // Notify WebSocket clients of changes
        context.rebuild = () => {
            console.log('Rebuilt, notifying clients...');
            wss.clients.forEach((client) => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send('reload');
                }
            });
        };

        // Start BrowserSync
        browserSync.init({
            proxy: proxyUrl,
            files: ['dist/*.js', 'index.html', 'dist/*.css'], // Watch these files for live reload
            port: 3000, // Serve files on this port
            open: true, // Automatically open in the browser
            codeSync: false  // Disable BrowserSync page reload
        });
    } else {
        // Run a one-time build
        await esbuild.build(buildOptions);
        console.log('Build completed');
    }
};

// Start the build process
build().catch((err) => {
    console.error(err);
    process.exit(1);
});