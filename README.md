GetRepoList.php
===============

Fetches all the repositories from a GitHub profile and puts them into a text file for later use.

Example
=======

    php GetRepoList.php --name="Dom" --url="http://github.com/dgendill"

Creates two files in the directory.

    Dom.html          // The HTML of the profile page
    DomRepoList.txt   // The list of repos. RepoName||||RepoURL

getrepo.sh will open the RepoList.txt and number the repositories.  You can choose the number, and the script will clone the repository into the current directory.