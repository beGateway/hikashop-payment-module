all:
	if [[ -e plg_hikashoppayment_begateway.zip ]]; then rm plg_hikashoppayment_begateway.zip; fi
	cd plg_hikashoppayment_begateway && zip -r ../plg_hikashoppayment_begateway.zip * -x "*/test/*" -x "*/.git/*" -x "*/examples/*"
