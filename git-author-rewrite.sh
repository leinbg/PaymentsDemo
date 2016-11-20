
#!/bin/sh

rm -rf .git/refs/original/

git filter-branch --env-filter '
OLD_EMAIL="wang@solutiondrive.de"
CORRECT_NAME="leinbg"
CORRECT_EMAIL="leiw4github@gmail.com"
if [ "$GIT_COMMITTER_EMAIL" = "$OLD_EMAIL" ]
then
    export GIT_COMMITTER_NAME="$CORRECT_NAME"
    export GIT_COMMITTER_EMAIL="$CORRECT_EMAIL"
fi
if [ "$GIT_AUTHOR_EMAIL" = "$OLD_EMAIL" ]
then
    export GIT_AUTHOR_NAME="$CORRECT_NAME"
    export GIT_AUTHOR_EMAIL="$CORRECT_EMAIL"
fi
' --tag-name-filter cat -- --branches --tags

git push --force --tags origin 'refs/heads/*'
