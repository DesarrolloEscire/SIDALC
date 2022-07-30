export VUFIND_HOME="/usr/local/vufind"
export VUFIND_LOCAL_DIR="/usr/local/vufind/local"
php /usr/local/vufind/harvest/harvest_oai.php
wait;
/usr/local/vufind/harvest/batch-import-xsl.sh RCAPDIG rcapdig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh ATDIG atdig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh ZAMOREV zamorev.properties
/usr/local/vufind/harvest/batch-import-xsl.sh IICADIG iicadig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh CATIEDIG catiedig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh UAAANREP uaaanrep.properties
/usr/local/vufind/harvest/batch-import-xsl.sh ZAMODIG zamodig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh UNADIG unadig.properties
/usr/local/vufind/harvest/batch-import-xsl.sh CEPALDIG cepaldig.properties
wait;
./import-marc.sh -p $VUFIND_LOCAL_DIR/import/import.unm.properties documents/koha.mrc
wait;
./index-alphabetic-browse.sh

