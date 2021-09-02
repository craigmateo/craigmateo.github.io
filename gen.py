# importing modules
import csv
import json

# csv file name
filename = "data.csv"

# initializing the titles and rows list
fields = []
rows = []

# initialize list for json objects

output = []

mols = []

with open(filename, 'r', encoding='utf-8-sig') as csvfile:
    # creating a csv reader object
    csvreader = csv.reader(csvfile)
      
    # extracting field names through first row
    fields = next(csvreader)
  
    # extracting each data row one by one
    for row in csvreader:
        rows.append(row)

for row in rows:
    row_dict = { 
    
    }
    # parsing each column of a row
    i=0;

    mols.append(row[0])

    for col in row:
        #print(i,fields[i],len(row),col)
        row_dict[fields[i]]=col
        i+=1
    output.append(row_dict)


#jsonString = json.dumps(output)

""" jsonFile = open("data.json", "w")
jsonFile.write(jsonString)
jsonFile.close() """
