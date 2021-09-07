cd application/config
ren config.php config1.php
ren config-backup.php config.php
ren config1.php config-backup.php
ren database.php database1.php
ren database-backup.php database.php
ren database1.php database-backup.php
cd ../../

git add .
git commit -m "new update on %date% "
git push github master
git push bluehost master

cd application/config
ren config.php config1.php
ren config-backup.php config.php
ren config1.php config-backup.php
ren database.php database1.php
ren database-backup.php database.php
ren database1.php database-backup.php
PAUSE