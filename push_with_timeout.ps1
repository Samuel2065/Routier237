# PowerShell script to push with extended timeout
$env:GIT_HTTP_LOW_SPEED_LIMIT = "0"
$env:GIT_HTTP_LOW_SPEED_TIME = "999999"
git config http.postBuffer 524288000
git config http.version HTTP/1.1
git push origin main
