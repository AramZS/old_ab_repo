#!/bin/sh
find older/ -type f -mtime +365 -print0 | xargs -0 rm -f
if [ -f *.sql ]
	then
		mv astrobetter_wp_backup.sql older/astrobetter_wp_backup_$(date +%Y%m%d).sql
		mv astrobetter_wp_backup.tar older/astrobetter_wp_backup_$(date +%Y%m%d).tar
		echo "older backup moved to directory named older"
fi
sudo mysqldump --add-drop-table -uroot -p7H{+sDK20EG0S/A.S:2?U'mnj astrobet_wp01 > astrobetter_wp_backup.sql
tar -cf astrobetter_wp_backup.tar astrobetter_wp_backup.sql
echo "new back up file created!"
