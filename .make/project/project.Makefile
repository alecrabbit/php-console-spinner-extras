include ${_PROJECT_DIR}/project.init.Makefile
include ${_PROJECT_DIR}/project.install.Makefile

PROJECT_SEL=${_C_SELECT} ${PROJECT_NAME} ${_C_STOP}

##
## —— Project 🚧 ———————————————————————————————————————————————————————————————
init: _initialize ## Initialize project and start docker hub

chown: ## Change the owner(user) of the project
	sudo chown -R ${USER_ID}:${GROUP_ID} .

project_info: ## Outputs project information
	@${_ECHO} "\n${PROJECT_SEL} ${_C_INFO} Project info...${_C_STOP}\n";
	@${_ECHO_DISABLED};
	@${_ECHO} "${_C_DEBUG} Add project info >>here<<${_C_STOP}\n";

env_reset: ## Resets environment variables
	@${_ECHO} "\n${PROJECT_SEL} ${_C_INFO} Resetting environment file...${_C_STOP}\n";
	@cp -v ${_ENV_DIST_FILE} ${_ENV_FILE};
	@${_ECHO};
	@${_ECHO_OK};

release: _release_message _do_release changelog ## Prepare for release
	@${_ECHO} "";

_release_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Preparing for release...${_C_STOP}\n";

_do_release:
	@${_BIN_DIR}/gitattributes.sh

changelog: _changelog_message _do_changelog ## Generate changelog
	@${_ECHO} "";

_changelog_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Generating changelog...${_C_STOP}\n";

_do_changelog:
	@-git-chglog --output CHANGELOG.md

