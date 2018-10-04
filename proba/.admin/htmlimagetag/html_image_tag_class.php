<?php
/*
 * html_image_tag.php
 *
 * @(#) $Id: html_image_tag_class.php,v 1.17 2008/08/10 02:03:02 mlemos Exp $
 *
 */

/*
{metadocument}<?xml version="1.0" encoding="ISO-8859-1"?>
<class>

	<package>net.manuellemos.htmlimagetag</package>

	<version>@(#) $Id: html_image_tag_class.php,v 1.17 2008/08/10 02:03:02 mlemos Exp $</version>
	<copyright>Copyright © (C) Manuel Lemos 2003</copyright>
	<title>HTML image tag generator</title>
	<author>Manuel Lemos</author>
	<authoraddress>mlemos@acm.org</authoraddress>

	<documentation>
		<idiom>en</idiom>
		<purpose>This class is meant to generate <tt>IMG</tt> HTML tag
			and its attributes for given images.<paragraphbreak />
			It can automatically compute the image size to fill the
			<tt>width</tt> and <tt>height</tt> attributes for images defined from
			locally accessible files.<paragraphbreak />
			The class can also generate an image tag with a special source URL
			that contains the actual image data defined according to RFC 2397.
			This way it, the image can be embedded in your HTML documents, making
			it possible to display the HTML documents without requiring external
			image files.<paragraphbreak />
			This may be useful for embeding images in single file HTML pages or
			including images in HTML e-mail messages without the need to attach
			the image files to the messages.<paragraphbreak />
			The data for embedded images may be supplied from a locally
			accessible file or from a string that contains the image file binary
			data.</purpose>
		<usage>Set the <variablelink>SRC</variablelink> and other class
			variables to specify the image details.<paragraphbreak />
			Call the <functionlink>GetMarkup</functionlink> function to generate
			the corresponding HTML <tt>IMG</tt> tag.<paragraphbreak />
			Call the <functionlink>GetFileDataURL</functionlink> function to
			generate the data URL of a locally accessible image file, so it can
			be used to embed images in HTML documents.<paragraphbreak />
			The <functionlink>GetDataURL</functionlink> function can be used to
			generate a data URL from string of binary data. The generated data
			URL may be of any type, not necessarily of an image.</usage>
	</documentation>

{/metadocument}
*/
class html_image_tag_class
{
/*
{metadocument}
	<variable>
		<name>SRC</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the image source URL, file name or binary data.</purpose>
			<usage>Set this variable with the URL or the name of the image
				file.<paragraphbreak />
				If you specify a local image file but you want the generated image
				tag to use its full URL, set the
				<variablelink>full_URI</variablelink> variable to
				<tt><booleanvalue>1</booleanvalue></tt> and set the
				<variablelink>base_url</variablelink> variable to the prefix that
				needs to prepended to the local file path to generate the expanded
				URL.<paragraphbreak />
				Set this variable to a string of binary data if you want to
				generate an HTML tag with an embedded image with its data passed
				explicitily. In this case set both the
				<variablelink>embedded</variablelink> and
				<variablelink>from_data</variablelink> variables to
				<tt><booleanvalue>1</booleanvalue></tt>.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $SRC='';

/*
{metadocument}
	<variable>
		<name>ALT</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the alternative text to present in the place of the image.</purpose>
			<usage>Set this variable with the text that you want to see displayed
				in circumstances when the image graphics cannot be presented. Set
				to an empty string if you do not want to specify an alternative
				text.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $ALT='';

/*
{metadocument}
	<variable>
		<name>TITLE</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the title text to display as tool tip.</purpose>
			<usage>Set this variable with the text that you want to see displayed
				as the image tool tip, usually when the user leaves the mouse
				pointer over the image in a graphical browser. Set to an empty
				string if you do not want to specify an alternative text.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $TITLE='';

/*
{metadocument}
	<variable>
		<name>ALIGN</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the type of vertical alignment of the image relatively
				the current text line.</purpose>
			<usage>Set this variable with either the values
				<tt><stringvalue>top</stringvalue></tt>,
				<tt><stringvalue>middle</stringvalue></tt> or
				<tt><stringvalue>top</stringvalue></tt> to specify the image
				vertical alignment. If you leave the empty string default value,
				the bottom of the image will appear align with the current text
				baseline.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $ALIGN='';

/*
{metadocument}
	<variable>
		<name>WIDTH</name>
		<type>INTEGER</type>
		<value>0</value>
		<documentation>
			<purpose>Pass the width of the image to be used when the class is not
				able to determine it automatically.</purpose>
			<usage>Set this variable with the number of pixels of width of the
				image so the class can use the value when it is not possible to
				determine the image width automatically, like for instance when
				is reference a remote image. Set this variable to
				<tt><integervalue>0</integervalue></tt> to tell the class to not
				generate the <tt>width</tt> attribute.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $WIDTH=0;

/*
{metadocument}
	<variable>
		<name>HEIGHT</name>
		<type>INTEGER</type>
		<value>0</value>
		<documentation>
			<purpose>Pass the height of the image to be used when the class is
				not able to determine it automatically.</purpose>
			<usage>Set this variable with the number of pixels of height of the
				image so the class can use the value when it is not possible to
				determine the image height automatically, like for instance when
				is reference a remote image. Set this variable to
				<tt><integervalue>0</integervalue></tt> to tell the class to not
				generate the <tt>height</tt> attribute.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $HEIGHT=0;

/*
{metadocument}
	<variable>
		<name>BORDER</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the width of the border around the image. When the
				image is used in an HTML link, the border is usually drawn with
				the link color.</purpose>
			<usage>Set this variable with a text string that contains the number
				of pixels of width of the image border. Leaving this variable
				default empty string will make the class not generate the
				<tt>border</tt> attribute, thus letting the browser assume the
				default border width. If you want to display the image without a
				border, set this variable to <tt><stringvalue>0</stringvalue></tt>.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $BORDER='';

/*
{metadocument}
	<variable>
		<name>STYLE</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the style attribute to render the image.</purpose>
			<usage>Set this variable with a text string that contains the style
				of the image. Leaving this variable default empty string will make
				the class not generate the <tt>style</tt> attribute.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $STYLE='';

/*
{metadocument}
	<variable>
		<name>CLASS</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Pass the CSS class attribute to render the image.</purpose>
			<usage>Set this variable with a text string that contains the name
				of the CSS class of the image. Leaving this variable default empty
				string will make the class not generate the <tt>class</tt>
				attribute.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $CLASS='';

/*
{metadocument}
	<variable>
		<name>mime_type</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the MIME type of the image.</purpose>
			<usage>If you are generating an embedded image tag from data, set
				this variable to the corresponding MIME type for the given
				image.<paragraphbreak />
				When the image has its size and type determined automatically by
				the class by analysing a locally accessible image file, the class
				sets this variable to the corresponding MIME type.</usage>
			<example><tt><stringvalue>image/gif</stringvalue></tt></example>
		</documentation>
	</variable>
{/metadocument}
*/
	var $mime_type='';

/*
{metadocument}
	<variable>
		<name>full_URI</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Indicate whether the image source needs to be expanded with
				a base URL prefix.</purpose>
			<usage>If you want the generated image tag to be expand by adding
				a base URL prefix, set this variable to
				<tt><booleanvalue>1</booleanvalue></tt> and the set the
				<variablelink>base_url</variablelink> variable with the URL prefix
				that you want to prepend to the URL specified by the
				<variablelink>SRC</variablelink> variable.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $full_URI=0;

/*
{metadocument}
	<variable>
		<name>base_url</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Specify the URL that will serve as prefix to the image file
				specified by the <variablelink>SRC</variablelink> variable.</purpose>
			<usage>If you want to generate an image tag with source URL set for a
				local image file, set the <variablelink>SRC</variablelink> to the
				image local file path, set the
				<variablelink>base_url</variablelink> to the prefix that you want
				to prepend to the image file path and set the
				<variablelink>full_URI</variablelink> to
				<tt><booleanvalue>1</booleanvalue></tt>.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $base_url='';

/*
{metadocument}
	<variable>
		<name>remote_image</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Indicate whether the image file is locally accessible.</purpose>
			<usage>If the specified image is locally accessible, the class may
				examine it to retrieve its dimensions. Additionally, the actual
				image data can be embedded in the generated image HTML tag.<paragraphbreak />
				If the image file is not locally accessible, this variable should
				be set to <tt><booleanvalue>1</booleanvalue></tt>. In this case,
				the class will use the values specified by the variables
				<variablelink>WIDTH</variablelink> and
				<variablelink>HEIGHT</variablelink> as dimensions.<paragraphbreak />
				Under some PHP versions with an appropriate configuration, it is
				possible to use remote images as locally acessible files by
				specifying the full URL in the <variablelink>SRC</variablelink>
				variable.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $remote_image=0;

/*
{metadocument}
	<variable>
		<name>embedded</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Indicate whether the generated image tag should include the
				actual image data.</purpose>
			<usage>If the image specified by the <variablelink>SRC</variablelink>
				is a locally accessible file, you can set the
				<variablelink>embedded</variablelink> variable to
				<tt><booleanvalue>1</booleanvalue></tt> if you would like the image
				data to be included in the generated image tag.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $embedded=0;

/*
{metadocument}
	<variable>
		<name>from_data</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Indicate whether the data for an embedded image is passed
				explicitly or it should be read from an image file.</purpose>
			<usage>To passed the data of an embedded image explicitly, set either
				this variable and <variablelink>embedded</variablelink> variable to
				<tt><booleanvalue>1</booleanvalue></tt> and then set the
				<variablelink>SRC</variablelink> variable to a string that contains
				the image binary data.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $from_data=0;

/*
{metadocument}
	<variable>
		<name>buffer_length</name>
		<type>INTEGER</type>
		<value>10000</value>
		<documentation>
			<purpose>Specify the maximum length of the buffer to be used when
				examining locally accessible image files.</purpose>
			<usage>Usually the default value of this variable is appropriate to
				read any type of image files. Change this variable only if you have
				a special reason to use a different maximum buffer length.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $buffer_length=10000;

/*
{metadocument}
	<variable>
		<name>error</name>
		<type>STRING</type>
		<value></value>
		<documentation>
			<purpose>Store the message that is returned when an error
				occurs.</purpose>
			<usage>Check this variable to understand what happened when a call to
				any of the class functions has failed.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $error='';

/*
{metadocument}
	<variable>
		<name>hidden</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Make the generated image not be visible.</purpose>
			<usage>Set this flag when you want to make the image be loaded but
				not be visible.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $hidden=0;

/*
{metadocument}
	<variable>
		<name>xhtml</name>
		<type>BOOLEAN</type>
		<value>0</value>
		<documentation>
			<purpose>Generate XHTML compliant HTML.</purpose>
			<usage>Set this flag when you want to make the generated HTML be
				compliant with XHTML.</usage>
		</documentation>
	</variable>
{/metadocument}
*/
	var $xhtml=0;

	var $size=array();

	Function ScriptDirectory()
	{
		$script_name=GetEnv('SCRIPT_NAME');
		$end=strrpos($script_name,'/');
		return((GetType($end)=='integer' && $end>1) ? substr($script_name,0,$end) : '');
	}

/*
{metadocument}
	<function>
		<name>GetDataURL</name>
		<type>STRING</type>
		<documentation>
			<purpose>Generate a data URL from from a binary data string.</purpose>
			<usage>Pass to the <argumentlink>
					<function>GetDataURL</function>
					<argument>data</argument>
				</argumentlink> argument a string that contains the binary data
				from which you want to generate the data URL. The <argumentlink>
					<function>GetDataURL</function>
					<argument>mime_type</argument>
				</argumentlink> argument should specify the MIME type of the data.</usage>
			<returnvalue>A text string that represents the data URL.</returnvalue>
		</documentation>
		<argument>
			<name>data</name>
			<type>STRING</type>
			<documentation>
				<purpose>String that contains the binary data.</purpose>
			</documentation>
		</argument>
		<argument>
			<name>mime_type</name>
			<type>STRING</type>
			<documentation>
				<purpose>MIME type of the binary data. It may be an empty string in
					case the MIME type of the data is unknown.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function GetDataURL($data,$mime_type)
	{
		return('data:'.$mime_type.';base64,'.chunk_split(base64_encode($data)));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>GetFileDataURL</name>
		<type>STRING</type>
		<documentation>
			<purpose>Generate a data URL of from locally accessible image file.</purpose>
			<usage>Pass to the <argumentlink>
					<function>GetFileDataURL</function>
					<argument>source</argument>
				</argumentlink> argument the local file path or an URL of the image
				source from which you want to generate the corresponding data URL.</usage>
			<returnvalue>A text string that represents the data URL of the
				specified image file.<paragraphbreak />
				If this function fails for some reason, it returns an empty string
				and the <variablelink>error</variablelink> variable is set to with
				an error message that explains the reason for the failure.</returnvalue>
		</documentation>
		<argument>
			<name>source</name>
			<type>STRING</type>
			<documentation>
				<purpose>Local file path or URL of the image source.</purpose>
			</documentation>
		</argument>
		<do>
{/metadocument}
*/
	Function GetFileDataURL($source)
	{
		if(strlen($source)==0)
		{
			$this->error='it was not specified an existing image file';
			return('');
		}
		if(GetType($size=@GetImageSize($this->SRC))!='array')
		{
			$this->error='it was not specified a supported image file';
			return('');
		}
		$this->size=$size;
		switch($size[2])
		{
			case 1:
				$this->mime_type='image/gif';
				break;
			case 2:
				$this->mime_type='image/jpeg';
				break;
			case 3:
				$this->mime_type='image/png';
				break;
			case 4:
				$this->mime_type='application/x-shockwave-flash';
				break;
			case 5:
				$this->mime_type='application/x-photoshop';
				break;
			case 6:
				$this->mime_type='image/bitmap';
				break;
			case 7:
				$this->mime_type='image/tiff';
				break;
			case 8:
				$this->mime_type='image/tiff';
				break;
			case 9:
				$this->mime_type='image/jpeg';
				break;
			case 10:
				$this->mime_type='image/jpeg';
				break;
			case 11:
				$this->mime_type='image/jpx';
				break;
			case 12:
				$this->mime_type='image/jb2';
				break;
			case 13:
				$this->mime_type='application/x-shockwave-flash';
				break;
			case 14:
				$this->mime_type='image/iff';
				break;
			case 15:
				$this->mime_type='image/vnd.wap.wbmp';
				break;
			case 16:
				$this->mime_type='image/xbm';
				break;
			default:
				if(!function_exists('image_type_to_mime_type')
				&& !strcmp($this->mime_type=strtolower(image_type_to_mime_type($this->size[2])),'application/octet-stream'))
				{
					$this->error='it was not specified an image file of supported type';
					return('');
				}
		}
		if(!($file=@fopen($source,'r')))
		{
			$this->error='could not open the source image file';
			return('');
		}
		for($data='';!feof($file);)
		{
			$block=fread($file,$this->buffer_length);
			$data.=$block;
		}
		fclose($file);
		if(strlen($data)==0)
		{
			$this->error='could not read the source image file';
			return('');
		}
		return('data:'.$this->mime_type.';base64,'.chunk_split(base64_encode($data)));
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

/*
{metadocument}
	<function>
		<name>GetMarkup</name>
		<type>STRING</type>
		<documentation>
			<purpose>Generate the HTML <tt>IMG</tt> tag that represents the image
				according to the values of the class variables.</purpose>
			<usage>Set the <variablelink>SRC</variablelink> and other class
				variables to specify the image from which you want to generate the
				corresponding HTML <tt>IMG</tt> tag.</usage>
			<returnvalue>A text string that is the image HTML <tt>IMG</tt> tag.<paragraphbreak />
				If this function fails for some reason, it returns an empty string
				and the <variablelink>error</variablelink> variable is set to with
				an error message that explains the reason for the failure.</returnvalue>
		</documentation>
		<do>
{/metadocument}
*/
	Function GetMarkup()
	{
		$source=$this->SRC;
		$this->size=array(
			$this->WIDTH,
			$this->HEIGHT,
			($this->WIDTH!=0 && $this->HEIGHT!=0) ? -1 : 0
		);
		if(!$this->remote_image)
		{
			if($this->embedded)
			{
				if($this->from_data)
					$source=$this->GetDataURL($this->SRC,$this->mime_type);
				else
				{
					$source=$this->GetFileDataURL($source);
					if(strlen($source)==0)
						return('');
				}
			}
			else
			{
				if(strlen($source)==0)
				{
					$this->error='it was not specified an existing image file';
					return('');
				}
				if(GetType($size=@GetImageSize($this->SRC))!='array')
				{
					$this->error='it was not specified a supported image file';
					return('');
				}
				$this->size=$size;
				if($this->full_URI)
					$source=(strlen($this->base_url) ? $this->base_url : $this->ScriptDirectory().'/').$source;
			}
		}
		return('<img src="'.$source.'"'.($this->hidden ? ' width="0" height="0"' : ($this->size[2]!=0 ? ' width="'.$this->size[0].'" height="'.$this->size[1].'"' : '')).(strlen($this->ALT) ? ' alt="'.$this->ALT.'"' : '').(strlen($this->TITLE) ? ' title="'.$this->TITLE.'"' : '').(strlen($this->ALIGN) ? ' align="'.$this->ALIGN.'"' : '').(strlen($this->BORDER) ? ' border="'.$this->BORDER.'"' : '').(strlen($this->STYLE) ? ' style="'.HtmlSpecialChars($this->STYLE).'"' : '').(strlen($this->CLASS) ? ' class="'.HtmlSpecialChars($this->CLASS).'"' : '').($this->xhtml ? '/' : '').'>');
	}
/*
{metadocument}
		</do>
	</function>
{/metadocument}
*/

};

/*

{metadocument}
</class>
{/metadocument}

*/

?>