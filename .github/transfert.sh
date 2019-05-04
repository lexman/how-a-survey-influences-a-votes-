#! /bin/sh
echo ${FTP_PASS}
echo $FTP_PASS
curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db
