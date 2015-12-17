
echo "Add users client postfix .."
useradd clientpostfix -g mail

echo "Starting ssmtp..."
#service ssmtp start > /dev/null 2>&1

launch () {
	# print command
	echo -n "\$$1: "
	echo "$2"

	# exec command
	sudo -u $1 \
		-H sh -c \
		"$2"
}

sleep 12
echo "-- Test Client --"
USER='clientpostfix'
COMMAND='echo "client postfix -> root "|mail -s "Bjr1" root@postfix'
launch "$USER" "$COMMAND"

USER='clientpostfix'
COMMAND='echo "client postfix -> Vincent "|mail -s "Bjr2" vincent@postfix'
launch "$USER" "$COMMAND"

USER='clientpostfix'
COMMAND='echo "client postfix -> noe -> Vincent "|mail -s "Bjr3" noe@postfix'
launch "$USER" "$COMMAND"
sleep 1
tail -f /opt/run.sh