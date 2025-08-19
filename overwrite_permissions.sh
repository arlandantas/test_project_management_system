git ls-files --others --exclude-standard | xargs -r sudo chown $USER
git ls-files --others --exclude-standard | xargs -r sudo chmod 755