echo "Download centrifugo"
wget --timeout=10 https://github.com/centrifugal/centrifugo/releases/download/v4.0.3/centrifugo_4.0.3_linux_amd64.tar.gz
tar xvfz centrifugo_4.0.3_linux_amd64.tar.gz centrifugo
rm -rf centrifugo_4.0.3_linux_amd64.tar.gz
chmod +x centrifugo

echo "Download VictoriaMetrics"
wget --timeout=10 https://github.com/VictoriaMetrics/VictoriaMetrics/releases/download/v1.83.0/victoria-metrics-linux-amd64-v1.83.0.tar.gz
tar xvfz victoria-metrics-linux-amd64-v1.83.0.tar.gz victoria-metrics-prod
rm -rf victoria-metrics-linux-amd64-v1.83.0.tar.gz
chmod +x victoria-metrics-prod
