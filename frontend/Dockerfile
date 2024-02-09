# Use the official Node.js image as base
FROM node:lts-alpine

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application files
COPY . .

# Expose port 8080
EXPOSE 8080
EXPOSE 8000

# Start the development server
CMD ["npm", "run", "serve"]
