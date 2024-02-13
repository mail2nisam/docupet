#!/bin/sh
set -e

# Install dependencies
npm install

# Start the development server
exec "$@"
