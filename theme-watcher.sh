#!/usr/bin/env bash
theme='arteml_penumbra_en_US'
grunt clean:$theme && grunt exec:$theme && grunt less:$theme && grunt watch
