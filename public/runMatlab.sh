#!/bin/bash

scp variables/${1}.txt admin@130.132.20.134:~/parameters

ssh admin@130.132.20.134 /Applications/MATLAB_R2015a.app/bin/matlab -nodesktop -noFigureWindows -nosplash -nodisplay -r "script_runSimCommLine\(\'/Users/admin/parameters/${1}.txt\'\)"

scp admin@130.132.20.134:~/mfm_ldep_web/output_file.txt results/${1}.txt

php ../artisan finishJob ${1}

echo "done"