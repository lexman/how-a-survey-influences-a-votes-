workflow "New workflow" {
  on = "watch"
  resolves = ["Donwload data"]
}

action "Donwload data" {
  uses = "docker://python:3.7-stretch"
  env = {
    FTP_PASS = "paspas"
  }
  args = "echo $FTP_PASS; curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db"
}
