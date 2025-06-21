const fusoUsuario = Intl.DateTimeFormat().resolvedOptions().timeZone;
document.cookie = "fuso_usuario=" + fusoUsuario + "; path=/";