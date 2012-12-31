#!/usr/bin/bash
# pull new projects files, open them in sublime
RepoName=$1
RepoURL=$2

if [[ $1 && $2 ]]; then
    echo `php c:/Users/Dom/Documents/projects/Programming/PHP/getGitHubRepos/GetRepoList.php --name=$1 --url=$2`
    RepoList="/cygdrive/c/Users/Dom/Documents/projects/Programming/PHP/getGitHubRepos/$1RepoList.txt"
else
    echo `php c:/Users/Dom/Documents/projects/Programming/PHP/getGitHubRepos/GetRepoList.php`
    RepoList="/cygdrive/c/Users/Dom/Documents/projects/Programming/PHP/getGitHubRepos/DomRepoList.txt"
fi

# http://tldp.org/LDP/abs/html/
# http://www.linuxjournal.com/content/bash-arrays
# http://stackoverflow.com/questions/2376031/reading-multiple-lines-in-bash-without-spawning-a-new-subshell
# http://www.grymoire.com/Unix/Awk.html#uh-2

count=1
links=("")
while read line; do
    
    name=${line%%||||*}
    url=${line##*||||}

    #OPT = `awk '$line' '----------' '{print $1}'`
    
    links[$count]=$url
    echo ${links[$count]}
    let count=$count+1
    #echo ${links[1]}
    echo $name
done < <(cat -n $RepoList)

echo "Choose the repo you want to clone:"
read input
choice=${links[$input]}
echo `git clone $choice`