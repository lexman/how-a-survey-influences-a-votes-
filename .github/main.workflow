workflow "New workflow" {
  on = "watch"
  resolves = ["Download data"]
}

action "Download data" {
  uses = "docker://python:3.7-stretch"
  runs = ["sh", "-c", "echo test $TEST_ENV $FTP_PASS"]
  secrets = ["FTP_PASS"]
  env = {
    TEST_ENV = "Test val"
  }
}

action "Download data from FTP" {
  uses = "docker://python:3.7-stretch"
  runs = ["sh", "-c", "curl ftp://ftp.online.net/opendata/imgs/.private/.db/survey.db --user webmaster@lexman.net:$FTP_PASS -o survey.db"]
  secrets = ["FTP_PASS"]
}

action "Push data to analytics" {
  uses = "docker://python:3.7-stretch"
  runs = ["sh", "-c", "echo Push"]
  secrets = ["FTP_PASS"]
}
