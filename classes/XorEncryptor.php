<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 30.10.13
 * Time: 22:13
 */

       class XorEncryptor {

              /** @var string ������-���� */
              private static $keyString = '964b07152d23';

              /**
               * ���������� ��������������� (��-)���������� ��������� ���������� ���� ����� (������������ UTF)
               * @param string $InputString ������ ��� ����������
               * @param string $KeyString ������-����
               * @return string ������������� ������
               */
              public static function xorEncrypt( $InputString, $KeyString )
              {
                     $KeyStringLength = mb_strlen( $KeyString );
                     $InputStringLength = mb_strlen( $InputString );
                     for ( $i = 0; $i < $InputStringLength; $i++ )
                     {
                            // ���� ������� ������ ������� ������-�����
                            $rPos = $i % $KeyStringLength;
                            // ��������� XOR ASCII-����� ��������
                            $r = ord( $InputString[$i] ) ^ ord( $KeyString[$rPos] );
                            // ���������� ��������� - ������, ��������������� ����������� ASCII-����
                            $InputString[$i] = chr($r);
                     }
                     return $InputString;
              }
              /**
               * ��������������� ������� ��� ���������� � ������, ������� ��� ������������� � �������
               * @param string $InputString
               * @return string
               */
              public static function encrypt( $InputString )
              {
                     $str = self::xorEncrypt( $InputString, self::$keyString );
                     $str = self::base64EncodeUrl( $str );
                     return $str;
              }
              /**
               * ��������������� ������� ��� ������������ �� ������, ������� ��� ������������� � ������� (������ � @link self::encrypt())
               * @param string $InputString
               * @return string
               */
              public static function decrypt( $InputString )
              {
                     $str = self::base64DecodeUrl( $InputString );
                     $str = self::xorEncrypt( $str, self::$keyString );
                     return $str;
              }
              /**
               * ����������� � base64 � ������� url-������������� ��������
               * @param string $Str
               * @return string
               */
              public static function base64EncodeUrl( $Str )
              {
                     return strtr( base64_encode( $Str ), '+/=', '-_,' );
              }
              /**
               * ������������� �� base64 � ������� url-������������� �������� (������ � @link self::base64EncodeUrl())
               * @param string $Str
               * @return string
               */
              public static function base64DecodeUrl( $Str )
              {
                     return base64_decode( strtr( $Str, '-_,', '+/=' ) );
              }
       }