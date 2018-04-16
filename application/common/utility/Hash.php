<?php
namespace app\common\utility;


class Hash
{
    /**
     * 对一个数组，并将其转换为标准格式. *
     * @param array $data 需要转换成标准格式的数组
     * @param bool $assoc 如果TRUE，$data将被转换为关联数组 .
     * @return array
     */
    public static function normalize(array $data, $assoc = true)
    {
        $keys = array_keys($data);
        $count = count($keys);
        $numeric = true;

        if (!$assoc) {
            for ($i = 0; $i < $count; $i++) {
                if (!is_int($keys[$i])) {
                    $numeric = false;
                    break;
                }
            }
        }
        if (!$numeric || $assoc) {
            $newList = array();
            for ($i = 0; $i < $count; $i++) {
                if (is_int($keys[$i])) {
                    $newList[$data[$keys[$i]]] = null;
                } else {
                    $newList[$keys[$i]] = $data[$keys[$i]];
                }
            }
            $data = $newList;
        }
        return $data;
    }


    public static function get(array $data, $path, $default = null)
    {
        if (empty($data) || $path === '' || $path === null) {
            return $default;
        }
        if (is_string($path) || is_numeric($path)) {
            $parts = explode('.', $path);
        } else {
            if (!is_array($path)) {
                exception($path . '应该是一个分隔符或者是一个数组');
            }
            $parts = $path;
        }

        foreach ($parts as $key) {
            if (is_array($data) && isset($data[$key])) {
                $data =& $data[$key];
            } else {
                return $default;
            }
        }

        return $data;
    }


    public static function extract(array $data, $path)
    {
        if (empty($path)) {
            return $data;
        }

        // Simple paths.
        if (!preg_match('/[{\[]/', $path)) {
            return (array)static::get($data, $path);
        }

        if (strpos($path, '[') === false) {
            $tokens = explode('.', $path);
        } else {
            $tokens = TpText::tokenize($path, '.', '[', ']');
        }

        $_key = '__set_item__';

        $context = array($_key => array($data));

        foreach ($tokens as $token) {
            $next = array();

            list($token, $conditions) = static::_splitConditions($token);

            foreach ($context[$_key] as $item) {
                foreach ((array)$item as $k => $v) {
                    if (static::_matchToken($k, $token)) {
                        $next[] = $v;
                    }
                }
            }

            // Filter for attributes.
            if ($conditions) {
                $filter = array();
                foreach ($next as $item) {
                    if (is_array($item) && static::_matches($item, $conditions)) {
                        $filter[] = $item;
                    }
                }
                $next = $filter;
            }
            $context = array($_key => $next);

        }
        return $context[$_key];
    }

    protected static function _splitConditions($token)
    {
        $conditions = false;
        $position = strpos($token, '[');
        if ($position !== false) {
            $conditions = substr($token, $position);
            $token = substr($token, 0, $position);
        }

        return array($token, $conditions);
    }

    protected static function _matchToken($key, $token)
    {
        switch ($token) {
            case '{n}':
                return is_numeric($key);
            case '{s}':
                return is_string($key);
            case '{*}':
                return true;
            default:
                return is_numeric($token) ? ($key == $token) : $key === $token;
        }
    }

    protected static function _matches(array $data, $selector)
    {
        preg_match_all(
            '/(\[ (?P<attr>[^=><!]+?) (\s* (?P<op>[><!]?[=]|[><]) \s* (?P<val>(?:\/.*?\/ | [^\]]+)) )? \])/x',
            $selector,
            $conditions,
            PREG_SET_ORDER
        );

        foreach ($conditions as $cond) {
            $attr = $cond['attr'];
            $op = isset($cond['op']) ? $cond['op'] : null;
            $val = isset($cond['val']) ? $cond['val'] : null;

            // Presence test.
            if (empty($op) && empty($val) && !isset($data[$attr])) {
                return false;
            }

            // Empty attribute = fail.
            if (!(isset($data[$attr]) || array_key_exists($attr, $data))) {
                return false;
            }

            $prop = null;
            if (isset($data[$attr])) {
                $prop = $data[$attr];
            }
            $isBool = is_bool($prop);
            if ($isBool && is_numeric($val)) {
                $prop = $prop ? '1' : '0';
            } elseif ($isBool) {
                $prop = $prop ? 'true' : 'false';
            }

            // Pattern matches and other operators.
            if ($op === '=' && $val && $val[0] === '/') {
                if (!preg_match($val, $prop)) {
                    return false;
                }
            } elseif (($op === '=' && $prop != $val) ||
                ($op === '!=' && $prop == $val) ||
                ($op === '>' && $prop <= $val) ||
                ($op === '<' && $prop >= $val) ||
                ($op === '>=' && $prop < $val) ||
                ($op === '<=' && $prop > $val)
            ) {
                return false;
            }

        }
        return true;
    }

    public static function filter(array $data, $callback = array('self', '_filter'))
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = static::filter($v, $callback);
            }
        }
        return array_filter($data, $callback);
    }

    protected static function _filter($var)
    {
        if ($var === 0 || $var === '0' || !empty($var)) {
            return true;
        }
        return false;
    }

    public static function format(array $data, array $paths, $format)
    {
        $extracted = array();
        $count = count($paths);

        if (!$count) {
            return null;
        }

        for ($i = 0; $i < $count; $i++) {
            $extracted[] = static::extract($data, $paths[$i]);
        }
        $out = array();
        $data = $extracted;
        $count = count($data[0]);

        $countTwo = count($data);
        for ($j = 0; $j < $count; $j++) {
            $args = array();
            for ($i = 0; $i < $countTwo; $i++) {
                if (array_key_exists($j, $data[$i])) {
                    $args[] = $data[$i][$j];
                }
            }
            $out[] = vsprintf($format, $args);
        }
        return $out;
    }

    public static function combine(array $data, $keyPath, $valuePath = null, $groupPath = null)
    {
        if (empty($data)) {
            return array();
        }

        if (is_array($keyPath)) {
            $format = array_shift($keyPath);
            $keys = static::format($data, $keyPath, $format);
        } else {
            $keys = static::extract($data, $keyPath);
        }
        if (empty($keys)) {
            return array();
        }

        if (!empty($valuePath) && is_array($valuePath)) {
            $format = array_shift($valuePath);
            $vals = static::format($data, $valuePath, $format);
        } elseif (!empty($valuePath)) {
            $vals = static::extract($data, $valuePath);
        }
        if (empty($vals)) {
            $vals = array_fill(0, count($keys), null);
        }

        if (count($keys) !== count($vals)) {
            exception('Hash::combine() needs an equal number of keys + values.');
        }

        if ($groupPath !== null) {
            $group = static::extract($data, $groupPath);
            if (!empty($group)) {
                $c = count($keys);
                for ($i = 0; $i < $c; $i++) {
                    if (!isset($group[$i])) {
                        $group[$i] = 0;
                    }
                    if (!isset($out[$group[$i]])) {
                        $out[$group[$i]] = array();
                    }
                    $out[$group[$i]][$keys[$i]] = $vals[$i];
                }
                return $out;
            }
        }
        if (empty($vals)) {
            return array();
        }
        return array_combine($keys, $vals);
    }

    public static function diff(array $data, $compare)
    {
        if (empty($data)) {
            return (array)$compare;
        }
        if (empty($compare)) {
            return (array)$data;
        }
        $intersection = array_intersect_key($data, $compare);
        while (($key = key($intersection)) !== null) {
            if ($data[$key] == $compare[$key]) {
                unset($data[$key]);
                unset($compare[$key]);
            }
            next($intersection);
        }
        return $data + $compare;
    }

    public static function merge(array $data, $merge)
    {
        $args = array_slice(func_get_args(), 1);
        $return = $data;

        foreach ($args as &$curArg) {
            $stack[] = array((array)$curArg, &$return);
        }
        unset($curArg);

        while (!empty($stack)) {
            foreach ($stack as $curKey => &$curMerge) {
                foreach ($curMerge[0] as $key => &$val) {
                    if (!empty($curMerge[1][$key]) && (array)$curMerge[1][$key] === $curMerge[1][$key] && (array)$val === $val) {
                        $stack[] = array(&$val, &$curMerge[1][$key]);
                    } elseif ((int)$key === $key && isset($curMerge[1][$key])) {
                        $curMerge[1][] = $val;
                    } else {
                        $curMerge[1][$key] = $val;
                    }
                }
                unset($stack[$curKey]);
            }
            unset($curMerge);
        }
        return $return;
    }

    public static function flatten(array $data, $separator = '.')
    {
        $result = array();
        $stack = array();
        $path = null;

        reset($data);
        while (!empty($data)) {
            $key = key($data);
            $element = $data[$key];
            unset($data[$key]);

            if (is_array($element) && !empty($element)) {
                if (!empty($data)) {
                    $stack[] = array($data, $path);
                }
                $data = $element;
                reset($data);
                $path .= $key . $separator;
            } else {
                $result[$path . $key] = $element;
            }

            if (empty($data) && !empty($stack)) {
                list($data, $path) = array_pop($stack);
                reset($data);
            }
        }
        return $result;
    }
}
