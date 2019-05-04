workflow "New workflow" {
  on = "watch"
  resolves = ["Download data"]
}

action "Download data" {
  uses = "docker://python:3.7-stretch"
  args = "transfert.sh"
  secrets = ["FTP_PASS"]
}
