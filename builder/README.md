# Configuration

## Create image
```batch
docker build -t yosmanyga/satis-builder .
```

## Generate

E.g.:

```batch
./generate.sh \
    folder_with_repo_txt_files \
    folder_where_satis_will_be_generated \
    "~/Work/Projects/%s/code"
```

```batch
./generate.sh \
    folder_with_repo_txt_files \
    folder_where_satis_will_be_generated \
    "https://github.com/%s"
```