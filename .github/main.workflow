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
