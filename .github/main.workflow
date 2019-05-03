workflow "New workflow" {
  resolves = ["docker://debian:-slim"]
  on = "watch"
}

action "docker://debian:-slim" {
  uses = "docker://debian:-slim"
  runs = "curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db"
  env = {
    FTP_PASS = "nline"
  }
}
