<?php

// caldria tindre la constant definida en algun lloc centralitzat, ja que estem duplicant-la.
const COOKIE_USERNAME = "last_used_name";

setcookie(COOKIE_USERNAME, "", 0);