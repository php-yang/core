<?php
if (class_exists('\Throwable')) {
    class_alias(\Throwable::class, '\Yang\Core\RootException');
} else {
    class_alias(\Exception::class, '\Yang\Core\RootException');
}
