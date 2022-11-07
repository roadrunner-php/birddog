echo "Download RoadRunner"
./vendor/bin/rr get-binary

echo "Download centrifugo"
wget --timeout=10 https://github.com/centrifugal/centrifugo/releases/download/v4.0.3/centrifugo_4.0.3_linux_amd64.tar.gz
tar xvfz centrifugo_4.0.3_linux_amd64.tar.gz centrifugo
mv centrifugo ./bin
rm -rf centrifugo_4.0.3_linux_amd64.tar.gz
chmod +x bin/centrifugo

echo "Download VictoriaMetrics"
wget --timeout=10 https://github.com/VictoriaMetrics/VictoriaMetrics/releases/download/v1.83.0/victoria-metrics-linux-amd64-v1.83.0.tar.gz
tar xvfz victoria-metrics-linux-amd64-v1.83.0.tar.gz victoria-metrics-prod
mv victoria-metrics-prod ./bin
rm -rf victoria-metrics-linux-amd64-v1.83.0.tar.gz
chmod +x bin/victoria-metrics-prod
