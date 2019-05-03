workflow "New workflow" {
  on = "watch"
  resolves = ["Donwload data"]
}

action "Donwload data" {
  uses = "docker://python:3.7-stretch"
  args = "echo ${FTP_PASS}; curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db"
  secrets = ["FTP_PASS"]
  runs = "echo ${FTP_PASS}"
}
