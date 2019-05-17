文件名称为：`.php_cs`

```php
<?php
$header
       = <<<EOF
team.samego.com
what team.samego is that is 'one thing, a team, work together'
EOF;
$rules = array(
    '@Symfony'                                   => true,
    'header_comment'                             => array('header' => $header),
    'array_syntax'                               => array('syntax' => 'short'),
    'ordered_imports'                            => true, // 按顺序use导入
    'no_useless_else'                            => true, // 删除没有使用的else节点
    'no_useless_return'                          => true, // 删除没有使用的return语句
    'php_unit_construct'                         => true,
    'single_quote'                               => true, //简单字符串应该使用单引号代替双引号
    'no_unused_imports'                          => true, //删除没用到的use
    'no_singleline_whitespace_before_semicolons' => true, //禁止只有单行空格和分号的写法
    'self_accessor'                              => true, //在当前类中使用 self 代替类名
    'no_empty_statement'                         => true, //多余的分号
    'no_whitespace_in_blank_line'                => true,
    'binary_operator_spaces'                     => ['default' => 'align_single_space'] //等号对齐、数字箭头符号对齐
);
return PhpCsFixer\Config::create()
                        ->setRiskyAllowed(true)
                        ->setRules($rules)
                        ->setFinder(
                            PhpCsFixer\Finder::create()
                                             ->exclude('vendor')
                                             ->in(__DIR__)
                        );
```

