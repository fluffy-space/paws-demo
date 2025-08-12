# Dependencies

## Root fluffy paws demo
https://github.com/fluffy-space/paws-demo.git
git clone https://github.com/fluffy-space/paws-demo.git temp && mv temp/.git .git && rm -rf temp


## Fluffy

git clone https://github.com/fluffy-space/fluffy.git temp && mv temp/.git vendor/fluffy-space/fluffy/.git && rm -rf temp && \
cd vendor/fluffy-space/fluffy && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../
code vendor/fluffy-space/fluffy


## Fluffy Paws

git clone https://github.com/fluffy-space/paws.git temp && mv temp/.git vendor/fluffy-space/paws/.git && rm -rf temp && \
cd vendor/fluffy-space/paws && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../
code vendor/fluffy-space/paws
git config core.filemode false

## Viewi

git clone https://github.com/viewi/viewi.git temp && mv temp/.git vendor/viewi/viewi/.git && rm -rf temp && \
cd vendor/viewi/viewi && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../
code vendor/viewi/viewi
git config core.filemode false

## Viewi Icons

git clone https://github.com/viewi/icons.git temp && mv temp/.git vendor/viewi/icons/.git && rm -rf temp && \
cd vendor/viewi/icons && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../
code vendor/viewi/icons
git config core.filemode false

## Viewi UI

git clone https://github.com/viewi/ui.git temp && mv temp/.git vendor/viewi/ui/.git && rm -rf temp && \
cd vendor/viewi/ui && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../
code vendor/viewi/ui
git config core.filemode false


## Remove ignored file from history

git rm --cached file1 file2 dir/file3

## Git pull vendor all

git clone https://github.com/fluffy-space/fluffy.git temp && mv temp/.git vendor/fluffy-space/fluffy/.git && rm -rf temp && \
cd vendor/fluffy-space/fluffy && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../ && \
git clone https://github.com/fluffy-space/paws.git temp && mv temp/.git vendor/fluffy-space/paws/.git && rm -rf temp && \
cd vendor/fluffy-space/paws && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../ && \
git clone https://github.com/viewi/viewi.git temp && mv temp/.git vendor/viewi/viewi/.git && rm -rf temp && \
cd vendor/viewi/viewi && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../ && \
git clone https://github.com/viewi/icons.git temp && mv temp/.git vendor/viewi/icons/.git && rm -rf temp && \
cd vendor/viewi/icons && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../ && \
git clone https://github.com/viewi/ui.git temp && mv temp/.git vendor/viewi/ui/.git && rm -rf temp && \
cd vendor/viewi/ui && \
git config core.filemode false && \
git pull && \
git checkout . && \
cd ../../../

HEAD
curl -I -k https://paws-demo.wsl.com/

OPTIONS
curl -I -k -X OPTIONS https://paws-demo.wsl.com/
curl -I -k -X OPTIONS https://paws-demo.wsl.com/api/admin/blog
curl -I -k -X OPTIONS https://paws-demo.wsl.com/api/admin/blog/2