# code-interview
Interview code example for Greatist.

## Challenge Request:

Hi Richard,
Guillermo requested you to review this code test/challenge.

## Challenge Specs:

Client wants a set of urls to pull an xml feed of content from the site in the form

    /feed/<content_type>/<taxonomy_vocabulary_name>/<term_names>
 
_Requirements_: 

* Can pull only 1 content type;
* from 1 vocabulary;
* but many terms.
 
Create a module / api that will accomplish this so that when I hit the url i get an xml feed of content. 

_Other Requirements_: 

* I should get 10 articles by default;
* but the number of results should be configurable somehow (Whether thats another parameter in the url or a general configuration page is up to you).
 
Example:

        /feed/article/categories/news|fitness|health
 
Returns by default 10 nodes of type article, tagged with the terms "news", "fitness" or health _from the categories vocabulary_.
 
* Proper validation should be used where appropriate;
* the results should reflect any non valid inputs (however you deem necessary).


## Usage

Stub

## Fixes

Stub

## TODO

## Testing

Stub
