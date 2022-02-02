## core-cms
Documentation
<br><br>

## Table of contents

- [Milestones (DONE)](#milestones-(done)) 
- [Milestones (TODO)](#milestones-todo) 
- [Database access & functions](#Database-access-&-functions)
- [SESSION access & variables & functions](#SESSION-access-&-variables-&-functions)
- [GLOBAL JavaScript & jQuery Variables](#GLOBAL-JavaScript-&-jQuery-Variables)
- [Modal/action parameters](#modal/action-parameters)
- [Important functions](#important-functions)
- [Creators](#creators)
- [Copyright and license](#copyright-and-license)


## Milestones (DONE)

- v0.5:
- User Management complete
- Database Log complete
- 


## Milestones (TODO)

- Live Validation via jquery and php (unique, email, type of input ...)


## Database access & functions


## SESSION access & variables & functions

<ul>
    <li>CORE.SESSIONIDENTIFIER - the user's session identifier</li>
    <li>CORE.CURRENTPAGE - the currently requested/displayed back-end page</li>
    <li>CORE.SHOWBE - sets the view state of the back-end</li>
    <br>
        <ul>
            <li>CORE.SHOWDASHBOARDAREA - view state of dashboard accordion item</li>
            <li>CORE.SHOWPAGESAREA - view state of pages accordion item</li>      
            <li>CORE.SHOWCONTENTAREA - view state of content accordion item</li>       
            <li>CORE.SHOWFILESAREA - view state of files accordion item</li>            
            <li>CORE.SHOWSYSTEMAREA - view state of system accordion item</li>
            <li>CORE.SHOWDBAREA - view state of database accordion item</li>    
            <li>CORE.SHOWEXTENSIONAREA - view state of extensions accordion item</li>         
        </ul>
</ul>

## GLOBAL JavaScript & jQuery Variables

<ul>
    <li>JQUERY_DEBUG_CONSOLE // coreJqueryDebug (db) - log jQuery Action to console</li>
</ul>

Back to [Table of contents](#table-of-contents)
<br><br>

## Modal/action parameters

The following data attributes must be set to allow the actions to proceed.
<ul>
    <li>action.be.general.delete.php: 
    data-table, 
    data-condition, 
    data-conditionvalue</li>
    <li>action.be.inplace.update.php: data-table, data-condition, data-conditionvalue, data-column, data-type, data-value (via be.action.js .val() selector), data-validateas (optional: set validation type: see core input validation types)</li>    
    <li>action.be.general.reorder.php: (as data-attribute of the sortable ul element) data-path, data-table</li> 
</ul>

Back to [Table of contents](#table-of-contents)

## Important functions

This is where to find some of the essential functions within core's files:
- movable list items: page.be.system.settings.php

Back to [Table of contents](#table-of-contents)

## Creators

**Michael Wienands**

michael@peakvision.ch

**Dr. Konrad Wienands**

info@drwienands.com



## Copyright and license

To be determined ... 