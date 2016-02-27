#!/bin/bash

# functions
launch () {
	# print command
	echo -e
	echo -n "\$$1: "
	echo "$2"

	# exec command
	sudo -u $1 \
		-H sh -c \
		"$2"
}

# ---- Configuration ----

echo "[START] Configuring Postfix..."
echo "   Add users client postfix .."
useradd clientuser -g mail
echo "[END] Configuring Postfix..."

# ---- Test ----

sleep 14 # wait for mysql & postfix server started

USER='clientuser'
COMMAND='echo "client mail -> root "|mail -s "Bjr1" root@zz2postfixproject.fr'
launch "$USER" "$COMMAND"

USER='clientuser'
COMMAND='echo "client mail -> Vincent "|mail -s "Bjr2" vincent@zz2postfixproject.fr'
launch "$USER" "$COMMAND"

USER='clientuser'
COMMAND='echo "client mail -> noe -> Vincent "|mail -s "Bjr3" noe@zz2postfixproject.fr'
launch "$USER" "$COMMAND"

#tail -f /opt/run.sh