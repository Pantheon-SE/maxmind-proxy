#!/bin/bash

# Check if mtr is installed
if ! command -v mtr &>/dev/null; then
    echo "Error: mtr could not be found. Please install mtr using 'brew install mtr' or via other methods."
    exit 1
fi

# Get the hostname as argument
HOSTNAME=$1
MTR_FILE="/tmp/${HOSTNAME}_tracer.json"

# Check if MTR file already exists
if [[ -f $MTR_FILE ]]; then
    echo "MTR data already exists for $HOSTNAME. Using existing data."
else
    echo "Running mtr for $HOSTNAME..."
    sudo mtr "$HOSTNAME" -jn > "$MTR_FILE"
    
    # Check if mtr was successful
    if [ $? -ne 0 ]; then
        echo "Error running mtr. Exiting."
        exit 1
    fi
    
    echo "MTR data saved to $MTR_FILE"
fi

# Convert the JSON file to a JSON string and then encode it in a URL-friendly way
encodedData=$(base64 < "$MTR_FILE" | tr -d '\n')

URL=$(echo "https://maxmind.pantheon.support/tracer?data=$encodedData")

# Provide the user with the URL
echo "Open the following URL to view the map: $URL"
open $URL
