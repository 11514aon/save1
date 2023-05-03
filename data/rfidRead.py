# RFID scan system (improvised)
import csv
import datetime
from getpass import getpass
import time
import threading
import os

# init var
data_tag = {}
seen_tags = set()
last_clear_time = datetime.datetime.now().replace(hour=7, minute=0, second=0, microsecond=0) 
# last_clear_time = datetime.datetime(2009, 10, 5, 18, 00) # test datetime for represent tag.csv clearing process

# daily flush thread
def clear_tags_daily():
    global seen_tags, tags_cleared, last_clear_time
    while True:
        now = datetime.datetime.now()
        if now.time() >= datetime.time(hour=7, minute=0) and now.date() > last_clear_time.date():
            with open('tags.csv', 'w', newline='') as f:
                pass
            seen_tags.clear()
            last_clear_time = now
        time.sleep(60)

# generate RFID Dictionary
with open('tag_dict.csv','r') as csvfile:
    reader = csv.reader(csvfile)
    for row in reader:
        rfid_tag, name_dict = row
        data_tag[rfid_tag] = name_dict

# reload seen tag (if accidentally stop)
with open('tags.csv', 'r') as csvfile:
    reader = csv.reader(csvfile)
    header = next(reader, None)
    if header is not None:
        for row in reader:
            seen_tags.add((row[0], row[1]))

clear_tags_thread = threading.Thread(target=clear_tags_daily)
clear_tags_thread.daemon = True
clear_tags_thread.start()

# clear screen thread
def clear_screen():
    while True:
        os.system('cls' if os.name == 'nt' else 'clear')  
        time.sleep(10)

clear_screen_thread = threading.Thread(target=clear_screen)
clear_screen_thread.daemon = True
clear_screen_thread.start()

# open main csv
with open('attendance.csv','a',newline="") as csvfile_main:
    writer = csv.writer(csvfile_main)
    today = datetime.datetime.now().date()
    checkin_time_start = datetime.time(hour=0, minute=0)
    checkin_time_end = datetime.time(hour=11, minute=59)
    checkout_time_start = datetime.time(hour=12, minute=0)
    checkout_time_end = datetime.time(hour=23, minute=59)
    # ... still open csv
    # get string input
    while True:
        name = ""
        dataScan = getpass("")
        if dataScan:
            current_time = datetime.datetime.now().time()
            if dataScan in data_tag: 
                # check selector
                # check-in (12AM-12PM)
                if checkin_time_start <= current_time <= checkin_time_end:
                    if (dataScan, 'check-in') not in seen_tags:
                        name = data_tag.get(dataScan)
                        print(f"Check-in successful: {name}")
                        writer.writerow([datetime.date.today() ,current_time, dataScan, 'check-in', name])
                        csvfile_main.flush()  # Flush the buffer to write the row immediately
                        seen_tags.add((dataScan, 'check-in'))
                        with open('tags.csv','a',newline="") as backup_csv:
                            tag_write = csv.writer(backup_csv)
                            tag_write.writerow([dataScan, 'check-in'])
                    else:
                        print(f"You are already checked in")
                # check-out (12PM-12AM)
                elif checkout_time_start <= current_time <= checkout_time_end:
                    if (dataScan, 'check-out') not in seen_tags:
                        name = data_tag.get(dataScan)
                        print(f"Check-out successful: {name}")
                        writer.writerow([datetime.date.today(), current_time, dataScan, 'check-out', name])
                        csvfile_main.flush()  # Flush the buffer to write the row immediately
                        seen_tags.add((dataScan, 'check-out'))
                        with open('tags.csv','a',newline="") as backup_csv:
                            tag_write = csv.writer(backup_csv)
                            tag_write.writerow([dataScan, 'check-out'])
                    else:
                        print(f"You are already checked out")
            else:
                print(f"Not registered")
        time.sleep(0.5)

'''
file information
- rfidRead.py : main program
- tag_dict.csv : datafile of all tags available
- attendance.csv : data file which store all scanned data
- tags.csv : seen_tags backup file (in case of unexpected terminate)
** seen_tags and tags.csv have a routine to clear themslef at 7AM everyday (might have error in first scan of the day
    due to input halting in while loop, it can halting clear process, unknown fix, solution is to double scan at first time of
    the day) + fixed by add daily flush thread - 28/4/2023
'''