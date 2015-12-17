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
useradd clientpostfix -g mail
echo "[END] Configuring Postfix..."

# ---- Test ----

sleep 12 # wait for mysql & postfix server started

USER='clientpostfix'
COMMAND='echo "client postfix -> root "|mail -s "Bjr1" root@postfix'
launch "$USER" "$COMMAND"

USER='clientpostfix'
COMMAND='echo "client postfix -> Vincent "|mail -s "Bjr2" vincent@postfix'
launch "$USER" "$COMMAND"

USER='clientpostfix'
COMMAND='echo "client postfix -> noe -> Vincent "|mail -s "Bjr3" noe@postfix'
launch "$USER" "$COMMAND"

#tail -f /opt/run.sh