include ${_APP_DIR}/app.Makefile

_do_project_set_flags: _do_apps_set_flags

_do_project_clear_flags: _do_apps_clear_flags

_do_project_init: _app_init
	@${_ECHO};
