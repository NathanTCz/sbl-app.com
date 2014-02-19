<?php
echo `ls | grep -v git-pull | xargs rm -rf`;
echo `git clone https://github.com/NathanTCz/sbl-app.com.git`;
echo `mv sbl-app.com/* sbl-app.com/.* ./`;
echo `cp ../config/sbl_config.php core/config.php`;
echo `rm -rf sbl-app.com`;
echo `cp ../config/sbl_config.php core/config.php`;
echo `mkdir logs`;
echo `touch logs/access.log`;
echo `touch logs/error.log`;
echo `touch logs/rewrite.log`;
?>
