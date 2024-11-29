create .env file with `PROXY_URL=dev-lab.local` (Replace with your local domain)

# esbuild Hot Reload Setup

This project demonstrates a hot reload setup using esbuild, WebSocket, and BrowserSync. It allows for a smooth development experience by automatically reloading the browser when changes are made to the source files.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)

## Prerequisites

Before you begin, ensure you have the following installed:

- [Node.js](https://nodejs.org/) (version 14 or higher)
- [npm](https://www.npmjs.com/) (comes with Node.js)

## Installation

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. Install the dependencies:

   ```bash
   npm install
   ```

3. Create a `.env` file in the root directory and set the `PROXY_URL` variable:

   ```env
   PROXY_URL=dev-lab.local
   ```

   Replace `dev-lab.local` with your local domain if necessary.

## Configuration

The project uses the following key files:

- **package.json**: Contains project metadata and dependencies.
- **build.js**: The main build script that configures esbuild and sets up WebSocket for hot reloading.
- **index.html**: The main HTML file that includes the bundled JavaScript and sets up WebSocket communication.
- **src/index.js**: The entry point for your JavaScript code.
- **src/style.css**: The main stylesheet for your application.

## Usage

To start the development server with hot reloading, run:

```bash
npm run watch
```

This command will:

- Build the project and watch for changes in the source files.
