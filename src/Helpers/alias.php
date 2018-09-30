<?php
// For type
if (interface_exists('\Throwable')) {
    class_alias(\Throwable::class, '\RootException');
} else {
    class_alias(\Exception::class, '\RootException');
}
