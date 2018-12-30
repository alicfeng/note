All is quiet at dead of night.

Terminal method
- this command will turn the icon hide
~~~shell
gconftool-2 --type Boolean --set /apps/docky-2/Docky/Items/DockyItem/ShowDockyItem False
~~~

- and this one back show 
~~~shell
gconftool-2 --type Boolean --set /apps/docky-2/Docky/Items/DockyItem/ShowDockyItem True
~~~

the last, Remember that you will need to restart Docky to see the changes take effect.
good ngiht~
