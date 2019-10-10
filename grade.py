import sys
from io import StringIO
old_stdout = sys.stdout
redirected_output = sys.stdout = StringIO()

#retrieve the code and what it should output
solution = sys.argv[1]
output = sys.argv[2]

#parse code for name

#determine what code returns and prints
retResult = exec(solution)
prinResult = redirected_output.getvalue()
sys.stdout = old_stdout

#do they match?
if prinResult == output:
    print('Your output is correct')
elif retResult == output:
    print('Your return is correct')
else:
    print('noh')
