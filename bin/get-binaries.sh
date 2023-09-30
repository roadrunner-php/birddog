echo "Download centrifugo"
wget --timeout=10 https://github.com/centrifugal/centrifugo/releases/download/v5.0.4/centrifugo_5.0.4_linux_amd64.tar.gz
tar xvfz centrifugo_5.0.4_linux_amd64.tar.gz centrifugo
rm -rf centrifugo_5.0.4_linux_amd64.tar.gz
chmod +x centrifugo

echo "Download VictoriaMetrics"
wget --timeout=10 https://github.com/VictoriaMetrics/VictoriaMetrics/releases/download/v1.93.5/victoria-metrics-linux-amd64-v1.93.5.tar.gz
tar xvfz victoria-metrics-linux-amd64-v1.93.5.tar.gz victoria-metrics-prod
rm -rf victoria-metrics-linux-amd64-v1.93.5.tar.gz
chmod +x victoria-metrics-prod
