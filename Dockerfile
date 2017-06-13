FROM mosaicoon/lep:stable

ARG buildenv="default"

ENV VHOST_ROOT "/app/code/public"
ENV FPM_CLEARENV "no"
ENV PHP_DISPLAYERRORS "On"
ENV PHP_ERRORREPORTING "E_ALL"
ENV PHP_MEMORYLIMIT "512M"
ENV APP_USER "application"
ENV APP_GROUP "application"
ENV FPM_USER "application"
ENV FPM_GROUP "application"

#Add Code
COPY . /app/code

WORKDIR /app/code

# Build
RUN if [ $buildenv != "local" ]; then set -x && \
composer update -o \
; fi
