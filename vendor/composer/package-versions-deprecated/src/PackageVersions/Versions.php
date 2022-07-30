<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'vufind/vufind';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'ahand/mobileesp' => 'dev-master@c02055dbe9baee63aab11438f4d7b5d25075d347',
  'bacon/bacon-qr-code' => '2.0.4@f73543ac4e1def05f1a70bcd1525c8a157a1ad09',
  'brick/varexporter' => '0.3.5@05241f28dfcba2b51b11e2d750e296316ebbe518',
  'cap60552/php-sip2' => 'v1.0.0@9904f94e857b7d4d4fd494f2d6634dcaf0d6e2c1',
  'colinmollenhour/credis' => 'v1.12.1@c27faa11724229986335c23f4b6d0f1d8d6547fb',
  'composer/package-versions-deprecated' => '1.11.99.2@c6522afe5540d5fc46675043d3ed5a45a740b27c',
  'composer/semver' => '3.2.5@31f3ea725711245195f62e54ffa402d8ef2fdba9',
  'container-interop/container-interop' => '1.2.0@79cbf1341c22ec75643d841642dd5d6acd83bdb8',
  'dasprid/enum' => '1.0.3@5abf82f213618696dda8e3bf6f64dd042d8542b2',
  'doctrine/annotations' => '1.13.2@5b668aef16090008790395c02c893b1ba13f7e08',
  'doctrine/cache' => '2.1.1@331b4d5dbaeab3827976273e9356b3b453c300ce',
  'doctrine/collections' => '1.6.8@1958a744696c6bb3bb0d28db2611dc11610e78af',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'doctrine/persistence' => '2.2.2@4ce4712e6dc84a156176a0fbbb11954a25c93103',
  'endroid/qr-code' => '4.2.2@53bfce79da95bf082484301fecbc1d77a3907f78',
  'filp/whoops' => '2.14.1@15ead64e9828f0fc90932114429c4f7923570cb1',
  'jasig/phpcas' => '1.4.0@ea27d122c4c7114006b33d15668c90f1904d53df',
  'laminas/laminas-cache' => '2.13.0@566948e32f30881cb903ffbd0e3e20dac00cd83e',
  'laminas/laminas-cache-storage-adapter-apcu' => '1.1.0@e182aab739d6b03992a9915cc3c7019391a94548',
  'laminas/laminas-cache-storage-adapter-blackhole' => '1.2.1@4af1053efd81785a292c2a9442871c075700345a',
  'laminas/laminas-cache-storage-adapter-ext-mongodb' => '1.2.0@72f68589cc8323fa688167a4720b795dd0907f4e',
  'laminas/laminas-cache-storage-adapter-filesystem' => '1.1.1@76fc488c3fa0ad442e4e70f807305c940d1bdcbc',
  'laminas/laminas-cache-storage-adapter-memcached' => '1.2.0@d05f33e43a352b85c6d0208e9cfbf2a59f02ede3',
  'laminas/laminas-cache-storage-adapter-memory' => '1.1.0@02c7a4a1118bbd47d1c0f0bfe1e8b140af79d2bd',
  'laminas/laminas-cache-storage-adapter-redis' => '1.2.0@de8a63d4a0ef1ccead401eb7fb6d75b57fa3f9ee',
  'laminas/laminas-cache-storage-adapter-session' => '1.1.0@74a275056cfca2300eb9a67cd1d917f7066b4113',
  'laminas/laminas-cache-storage-adapter-zend-server' => '1.0.1@8d0b0d219a048a92472d89a5e527990f3ea2decc',
  'laminas/laminas-captcha' => '2.10.0@9a0134e434cd792934ecca42cb66f316be7bba50',
  'laminas/laminas-code' => '3.5.1@b549b70c0bb6e935d497f84f750c82653326ac77',
  'laminas/laminas-config' => '3.5.0@f91cd6fe79e82cbbcaa36485108a04e8ef1e679b',
  'laminas/laminas-crypt' => '3.4.0@a058eeb2fe57824b958ac56753faff790a649e18',
  'laminas/laminas-db' => '2.12.0@80cbba4e749f9eb7d8036172acb9ad41e8b6923f',
  'laminas/laminas-dom' => '2.8.0@7e85e8d7d2980c716944b8bb8e4a83c0a0dbe91b',
  'laminas/laminas-escaper' => '2.8.0@2d6dce99668b413610e9544183fa10392437f542',
  'laminas/laminas-eventmanager' => '3.3.1@966c859b67867b179fde1eff0cd38df51472ce4a',
  'laminas/laminas-feed' => '2.14.1@463fdae515fba30633906098c258d3b2c733c15c',
  'laminas/laminas-filter' => '2.11.1@671724e163aa75c210e94d12b77a0f3f8240d4b2',
  'laminas/laminas-form' => '3.0.1@2cb637d246d44fcb2a55aa6735df6769c5c0f0cb',
  'laminas/laminas-http' => '2.14.3@bfaab8093e382274efed7fdc3ceb15f09ba352bb',
  'laminas/laminas-hydrator' => '4.3.1@cc5ea6b42d318dbac872d94e8dca2d3013a37ab5',
  'laminas/laminas-i18n' => '2.11.2@78adb53ebf6c0bc63f92273fd7809dabc554f786',
  'laminas/laminas-inputfilter' => '2.12.0@b6ab28b425e626b12488fec243e02d36d8dffeff',
  'laminas/laminas-json' => '3.3.0@9a0ce9f330b7d11e70c4acb44d67e8c4f03f437f',
  'laminas/laminas-loader' => '2.7.0@bcf8a566cb9925a2e7cc41a16db09235ec9fb616',
  'laminas/laminas-log' => '2.13.1@6ac20830d4f324b4662fc454fcc1954436bfced3',
  'laminas/laminas-mail' => '2.14.1@180c6c7baa37cba16fe9fd34af0f346e796cf1a1',
  'laminas/laminas-math' => '3.3.2@188456530923a449470963837c25560f1fdd8a60',
  'laminas/laminas-mime' => '2.9.0@02cc861f704d468726866457dcf8338d1fe74e76',
  'laminas/laminas-modulemanager' => '2.10.2@2068e0b300e87e139112016a6025be341ceaaf33',
  'laminas/laminas-mvc' => '3.2.0@88da7200cf8f5a970c35d91717a5c4db94981e5e',
  'laminas/laminas-mvc-i18n' => '1.2.0@7ece491a02000a6c4ea2c4457fead3d12efc6eba',
  'laminas/laminas-mvc-plugin-flashmessenger' => '1.3.0@f7569d05dfd774a2c84328792ee716e2d8b1e33e',
  'laminas/laminas-paginator' => '2.10.0@14ce4a397e6329954389cc40aa635caa9573f695',
  'laminas/laminas-paginator-adapter-laminasdb' => '1.0.0@567bf94a4b878fcff76552dd7aa6e40c22ace466',
  'laminas/laminas-recaptcha' => '3.3.0@3275b19ee8a58007e508b2ea3fd2160582abdb73',
  'laminas/laminas-router' => '3.4.5@aaf2eb364eedeb5c4d5b9ee14cd2938d0f7e89b7',
  'laminas/laminas-serializer' => '2.10.1@254cf6a17b46d98808c0810939268f63538dcc0c',
  'laminas/laminas-server' => '2.10.0@e1fd6853223feed7a00555144d661e0a914124cd',
  'laminas/laminas-servicemanager' => '3.7.0@2b0aee477fdbd3191af7c302b93dbc5fda0626f4',
  'laminas/laminas-session' => '2.11.0@c4e19f1a3bc6f7ecf6f25f79b32717a544236922',
  'laminas/laminas-soap' => '2.9.0@11672a79e9074fd8e4e7aedd75849902e7b45e23',
  'laminas/laminas-stdlib' => '3.5.0@c8ac6a76a133e682acfabc821d4a2ec646934b12',
  'laminas/laminas-text' => '2.8.1@d696fa1fb3880b9b8f02c08be58685013b421608',
  'laminas/laminas-uri' => '2.8.1@79bd4c614c8cf9a6ba715a49fca8061e84933d87',
  'laminas/laminas-validator' => '2.14.5@4680bc4241cb5b3ff78954c421fe43105ca413b7',
  'laminas/laminas-view' => '2.12.0@3ef103da6887809f08ecf52f42c31a76c9bf08b1',
  'laminas/laminas-zendframework-bridge' => '1.4.0@bf180a382393e7db5c1e8d0f2ec0c4af9c724baf',
  'league/commonmark' => '1.6.6@c4228d11e30d7493c6836d20872f9582d8ba6dcf',
  'lm-commons/lmc-rbac-mvc' => 'v3.3.0@26ee8a3c4136d9df988b0eb63e9f30e2fee874bc',
  'matthiasmullie/minify' => '1.3.66@45fd3b0f1dfa2c965857c6d4a470bea52adc31a6',
  'matthiasmullie/path-converter' => '1.1.3@e7d13b2c7e2f2268e1424aaed02085518afa02d9',
  'nikic/php-parser' => 'v4.12.0@6608f01670c3cc5079e18c1dab1104e002579143',
  'ocramius/proxy-manager' => '2.2.3@4d154742e31c35137d5374c998e8f86b54db2e2f',
  'pear/archive_tar' => '1.4.14@4d761c5334c790e45ef3245f0864b8955c562caa',
  'pear/console_getopt' => 'v1.4.3@a41f8d3e668987609178c7c4a9fe48fecac53fa0',
  'pear/file_marc' => '1.4.1@a4997f93d13933ad478cd8b6f43c6345d7388a70',
  'pear/http_request2' => 'v2.5.0@8c52c1343a709110b4080118bd99f53dcd2b052f',
  'pear/net_url2' => 'v2.2.2@07fd055820dbf466ee3990abe96d0e40a8791f9d',
  'pear/pear-core-minimal' => 'v1.10.11@68d0d32ada737153b7e93b8d3c710ebe70ac867d',
  'pear/pear_exception' => 'v1.0.2@b14fbe2ddb0b9f94f5b24cf08783d599f776fff0',
  'pear/validate' => 'v0.8.6@d317d213b1a6bf06e5616bee24d4fcc26449c1e9',
  'pear/validate_ispn' => 'v0.8.0@40272ba7f7eec3756aec29ba1f2f836c32edfcc3',
  'phing/phing' => '2.17.0@c0a3bce822c088d60b30a577c25debb42325d0f8',
  'ppito/laminas-whoops' => '2.2.0@1507b42caeefc56511ab591ebd87c6700d111409',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.1.1@8622567409010282b7aeebe4bb841fe98b58dcaf',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'scssphp/scssphp' => 'v1.6.0@b83594e2323c5d6e80785df3f91b9d1d32aad530',
  'serialssolutions/summon' => 'v1.3.1@78ef74123c7c15fe3ddc92c9c1368c5dae9e590d',
  'slm/locale' => 'v0.5.0@7357acd8db5c3cec57198e3b301cf8dfd1ae7814',
  'swagger-api/swagger-ui' => 'v3.52.0@b1ccd1f03a77cfd88b76c1cf3e07b6af7f9bbd7b',
  'symfony/console' => 'v5.3.6@51b71afd6d2dc8f5063199357b9880cea8d8bfe2',
  'symfony/deprecation-contracts' => 'v2.4.0@5f38c8804a9e97d23e0c8d63341088cd8a22d627',
  'symfony/polyfill-ctype' => 'v1.23.0@46cd95797e9df938fdd2b03693b5fca5e64b01ce',
  'symfony/polyfill-intl-grapheme' => 'v1.23.1@16880ba9c5ebe3642d1995ab866db29270b36535',
  'symfony/polyfill-intl-normalizer' => 'v1.23.0@8590a5f561694770bdcd3f9b5c69dde6945028e8',
  'symfony/polyfill-mbstring' => 'v1.23.1@9174a3d80210dca8daa7f31fec659150bbeabfc6',
  'symfony/polyfill-php72' => 'v1.23.0@9a142215a36a3888e30d0a9eeea9766764e96976',
  'symfony/polyfill-php73' => 'v1.23.0@fba8933c384d6476ab14fb7b8526e5287ca7e010',
  'symfony/polyfill-php80' => 'v1.23.1@1100343ed1a92e3a38f9ae122fc0eb21602547be',
  'symfony/service-contracts' => 'v2.4.0@f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb',
  'symfony/string' => 'v5.3.7@8d224396e28d30f81969f083a58763b8b9ceb0a5',
  'symfony/yaml' => 'v5.3.6@4500fe63dc9c6ffc32d3b1cb0448c329f9c814b7',
  'true/punycode' => 'v2.1.1@a4d0c11a36dd7f4e7cd7096076cab6d3378a071e',
  'vstelmakh/url-highlight' => 'v3.0.0@294fe9bfb36e3cacd6d93b378400ad8becefa10a',
  'vufind-org/vufindcode' => 'v1.2@df7f4d2188c9f2c654dfee69774b80b9d03b1ab4',
  'vufind-org/vufinddate' => 'v1.0.0@1bec5458b48d96fa8ff87123584042780f4c3c24',
  'vufind-org/vufindharvest' => 'v4.1.0@b0b5573ccc7993ed258deda19b8c2ba0a33e6395',
  'vufind-org/vufindhttp' => 'v3.1.0@69aff6bcb84139598bdb42d161b7483caf69b1c2',
  'webfontkit/open-sans' => '1.0.0@00ab31e690edfd0d88f9ffbcd998cf298b9687e9',
  'webimpress/safe-writer' => '2.2.0@9d37cc8bee20f7cb2f58f6e23e05097eab5072e6',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'wikimedia/composer-merge-plugin' => 'v2.0.1@8ca2ed8ab97c8ebce6b39d9943e9909bb4f18912',
  'wikimedia/less.php' => 'v3.1.0@a486d78b9bd16b72f237fc6093aa56d69ce8bd13',
  'yajra/laravel-pdo-via-oci8' => 'v2.2.0@93610843b7abe975413288bcc4adb347edefb4b8',
  'zfr/rbac' => '1.2.0@493711bfc2a637fd7c6f23b71b7b55a621c35d9d',
  'laminas/laminas-cache-storage-adapter-apc' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'laminas/laminas-cache-storage-adapter-dba' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'laminas/laminas-cache-storage-adapter-memcache' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'laminas/laminas-cache-storage-adapter-mongodb' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'laminas/laminas-cache-storage-adapter-wincache' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'laminas/laminas-cache-storage-adapter-xcache' => '*@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
  'vufind/vufind' => 'dev-release-8.0@a1911ad20fbf2f7e2e4b4a77f33ae42c6da45f70',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !(method_exists(InstalledVersions::class, 'getAllRawData') ? InstalledVersions::getAllRawData() : InstalledVersions::getRawData())) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && (method_exists(InstalledVersions::class, 'getAllRawData') ? InstalledVersions::getAllRawData() : InstalledVersions::getRawData())) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}