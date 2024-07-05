#!/bin/bash

# Folder where the txt files are stored
LIST=$1
# Folder where satis.json will be generated
SATIS=$2
# Url where libs reside, e.g.: ~/Work/Projects/%s/code, https://github.com/%s
URL=$3

# Regenerate satis.json
docker run --rm -it \
  --user "$(id -u):$(id -g)" \
  --volume "${LIST}:/list" \
  --volume "${SATIS}:/satis" \
  yosmanyga/satis-builder /list /satis "${URL}"

# Regenerate public
docker run --rm -it \
  --user "$(id -u):$(id -g)" \
	--volume "${SATIS}:/build" \
	--volume "${COMPOSER_HOME:-$HOME/.composer}:/composer" \
	--volume /home/yosmanyga/Work/Projects:/home/yosmanyga/Work/Projects \
	composer/satis build satis.json public

rm -rf "${SATIS}/satis.json"