var globalX = 0, globalY = 0;

function elem1(id)
{
	return document.getElementById(id);
}

function mousePageXY(e)
{
  var x = 0, y = 0;

  if (!e) e = window.event;

  if (e.pageX || e.pageY)
  {
    x = e.pageX;
    y = e.pageY;
  }
  else if (e.clientX || e.clientY)
  {
    x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
    y = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
  }

  return {"x":x, "y":y};
}

//document.onmousemove = function(e){var mCur = mousePageXY(e); globalX = mCur.x; globalY = mCur.y;};

function getCookie(name)
{
  if(document.cookie.indexOf(' ' + name + '=') < 0)
  {
  	return null;
  }
  else
  {
    var tmp = document.cookie.substr(document.cookie.indexOf(' ' + name + '='));
    if(tmp.indexOf(';') > 0)
    {
      tmp = tmp.substr(0, tmp.indexOf(';'));
    }
  	tmp = tmp.substr(tmp.indexOf('=') + 1);
    return tmp;
  }
}

function dump(obj)
{
  var out = '';
  for (var i in obj)
  {
    out += i + ": " + obj[i] + "\n";
  }
  return out;
}

function dump2(obj)
{
  var out = '';
  for (var i in obj)
  {
    out += i + ": " + obj[i] + "<br/>";
  }
  return out;
}

function get_w()
{
  var frameWidth=800;
  if (self.innerWidth)
    frameWidth = self.innerWidth;
  else if (document.documentElement && document.documentElement.clientWidth)
    frameWidth = document.documentElement.clientWidth;
  else if (document.body)
    frameWidth = document.body.clientWidth;
  return frameWidth;
}

function get_h()
{
  var frameHeight=640;
  if (self.innerHeight)
    frameHeight = self.innerHeight;
  else if (document.documentElement && document.documentElement.clientHeight)
    frameHeight = document.documentElement.clientHeight;
  else if (document.body)
    frameHeight = document.body.clientHeight;
  return frameHeight;
}

function stop_event(event)
{
  if (event && event.stopPropagation)
  {
	  event.stopPropagation();
	}
	else
	{
	  window.event.cancelBubble = true;
  }
	return false;
}
