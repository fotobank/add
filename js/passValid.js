/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.10.13
 * Time: 23:43
 * To change this template use File | Settings | File Templates.
 */

var m_strUpperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
var m_strLowerCase = "abcdefghijklmnopqrstuvwxyz";
var m_strNumber = "0123456789";
var m_strCharacters = "!@#$%^&*?_~"

// Check password
function checkPassword(strPassword)
{
// Reset combination count
    var nScore = 0;

// Password length
// -- Less than 4 characters
    if (strPassword.length < 5)
    {
        nScore += 5;
    }
// -- 5 to 7 characters
    else if (strPassword.length > 4 && strPassword.length < 8)
    {
        nScore += 10;
    }
// -- 8 or more
    else if (strPassword.length > 7)
    {
        nScore += 25;
    }

// Letters
    var nUpperCount = countContain(strPassword, m_strUpperCase);
    var nLowerCount = countContain(strPassword, m_strLowerCase);
    var nLowerUpperCount = nUpperCount + nLowerCount;
// -- Letters are all lower case
    if (nUpperCount == 0 && nLowerCount != 0)
    {
        nScore += 10;
    }
// -- Letters are upper case and lower case
    else if (nUpperCount != 0 && nLowerCount != 0)
    {
        nScore += 20;
    }

// Numbers
    var nNumberCount = countContain(strPassword, m_strNumber);
// -- 1 number
    if (nNumberCount == 1)
    {
        nScore += 10;
    }
// -- 3 or more numbers
    if (nNumberCount >= 3)
    {
        nScore += 20;
    }

// Characters
    var nCharacterCount = countContain(strPassword, m_strCharacters);
// -- 1 character
    if (nCharacterCount == 1)
    {
        nScore += 10;
    }
// -- More than 1 character
    if (nCharacterCount > 1)
    {
        nScore += 25;
    }

// Bonus
// -- Letters and numbers
    if (nNumberCount != 0 && nLowerUpperCount != 0)
    {
        nScore += 2;
    }
// -- Letters, numbers, and characters
    if (nNumberCount != 0 && nLowerUpperCount != 0 && nCharacterCount != 0)
    {
        nScore += 3;
    }
// -- Mixed case letters, numbers, and characters
    if (nNumberCount != 0 && nUpperCount != 0 && nLowerCount != 0 && nCharacterCount != 0)
    {
        nScore += 5;
    }

    return nScore;
}

// Runs password through check and then updates GUI
function runPassword(strPassword, strFieldID)
{
// Check password
    var nScore = checkPassword(strPassword);

// Get controls
    var ctlBar = document.getElementById(strFieldID + "_bar");
    var ctlText = document.getElementById(strFieldID + "_text");
    if (ctlBar && ctlText) {

// Set new width
    ctlBar.style.width = nScore + "%";

// Color and text
// -- Безупречный

    var strText = "";
    var strColor = "";
    if (nScore >= 90)
    {
         strText = "Отличный пароль!";
         strColor = "#0ca908";
    }
// -- Очень хороший
    else if (nScore >= 80)
    {
         strText = "Очень хороший";
         strColor = "#7ff67c";
    }
// -- Хороший
    else if (nScore >= 70)
    {
         strText = "Хороший";
         strColor = "#1740ef";
    }
// -- Давольно нормальный
    else if (nScore >= 60)
    {
         strText = "Достаточно неплохо";
         strColor = "#5a74e3";
    }
// -- Нормальный
    else if (nScore >= 50)
    {
         strText = "Нормально";
         strColor = "#e3cb00";
    }
// -- Слабый
    else if (nScore >= 25)
    {
         strText = "Слабенько";
         strColor = "#e7d61a";
    }
// -- Очень плохой
    else
    {
         strText = "Очень слабый пароль!";
         strColor = "#e71a1a";
    }
    ctlBar.style.backgroundColor = strColor;
    ctlText.innerHTML = "<span style='color: " + strColor + ";'>" + strText + " - " + nScore + "</span>";
    }
}

// Checks a string for a list of characters
function countContain(strPassword, strCheck)
{
// Declare variables
    var nCount = 0;

    for (i = 0; i < strPassword.length; i++)
    {
        if (strCheck.indexOf(strPassword.charAt(i)) > -1)
        {
            nCount++;
        }
    }

    return nCount;
}