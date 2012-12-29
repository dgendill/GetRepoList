GetRepoList.php
===============

Fetches all the repositories from a GitHub profile and puts them into a JSON file for later use.

Example
=======

    php GetRepoList.php --name="Dom" --url="http://github.com/dgendill"

Creates two files in the directory.

    Dom.html          // The HTML of the profile page
    DomRepoList.json  // The JSON list of repos. "RepoName" => "RepoURL"