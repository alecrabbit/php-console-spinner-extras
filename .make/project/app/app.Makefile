include ${_APP_DIR}/app.init.Makefile

##
## —— Application 🚧 ———————————————————————————————————————————————————————————
app: ## Start application
	@${_ECHO} "\n${PROJECT_SEL} ${_C_INFO} Starting application...${_C_STOP}\n";
	@${_ECHO_DISABLED};
	@${_ECHO} "${_C_DEBUG} Add application start >>here<<${_C_STOP}\n";