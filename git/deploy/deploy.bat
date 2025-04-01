#!/bin/bash

# Variables
SERVER="147.79.103.150"
USER="u695647153"
REMOTE_DIR="/home/u695647153/domains/brazatlant.eu/public_html/"
LOCAL_DIR="main/"

MODIFIED_FILES=$(git diff --name-only HEAD)

# Ouvrir une session SFTP et transférer les fichiers modifiés
sftp $USER@$SERVER <<EOF
cd $REMOTE_DIR
lcd $LOCAL_DIR
$(for FILE in $MODIFIED_FILES; do echo "put $FILE"; done)
bye
EOF

echo "Déploiement terminé avec succès !"
