workflow "New workflow" {
  on = "watch"
  resolves = ["Push data to analytics"]
}

action "Download data from FTP" {
  uses = "docker://python:3.7-stretch"
  runs = ["sh", "-c", "curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db"]
  secrets = ["FTP_PASS"]
}

action "Push data to analytics" {
  uses = "docker://python:3.7-stretch"
  runs = ["sh", "-c", "echo Push"]
  needs = ["Download data from FTP"]
}
