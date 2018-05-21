<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>The BMW Shorties Email Notification - BMW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">

      @font-face {
        font-family: BMWTypeVTwo_Light;
        src: url('font/bmwl.eot');
        src: url('font/bmwl.woff2') format('woff2'),
             url('font/bmwl.eot?#iefix') format('embedded-opentype');
        font-weight: normal;
        font-style: normal;
      }

      @font-face {
        font-family: BMWTypeVTwo_LightBOLD;
        src: url('font/bmwlb.eot');
        src: url('font/bmwlb.woff2') format('woff2'),
             url('font/bmwlb.eot?#iefix') format('embedded-opentype');
        font-weight: normal;
        font-style: normal;
      }

      html{width: 100%; background:#fff; font-family: BMWTypeVTwo_LightBOLD;}
      h1 { font-family: BMWTypeVTwo_LightBOLD; color: #000000; font-size: 2em; margin-bottom: 1em; font-weight: 700;}
      h2 {font-family: BMWTypeVTwo_LightBOLD; color: #000000; font-size: 1.2em; font-weight: 700;}
      span { color: #000000; font-weight: 700; font-family: BMWTypeVTwo_LightBOLD;}
    </style> 
  </head>
  <body style="margin: 0; padding: 0;">
    <table align="center" cellpadding="0" cellspacing="0" width="800" style="border-collapse: collapse;     border: 1px solid #000;">
      <tr>
          <td align="left" bgcolor="#fff" style="padding: 0;">
            <img src="{{url('img/bmw/aboutus-banner-07.png')}}"  style="display: block; width: 100%;" alt="The BMW Shorties Email Notification - Participants"> 
          </td> 
      </tr>


      <tr>
        <td align="justify" bgcolor="#fff" style="padding:2em 6em ;background-color: #ffffff;">
          <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td width="100%" valign="top" align="justify">
                 <table cellpadding="0" cellspacing="0" width="100%">
                  
                  <tr>
                    <td width="260" valign="top" align="justify">
                      <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">Hi <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">Administrator </span>,   </span> <br><br>
                    </td>  
                  </tr>

                  <tr>
                    <td width="260" valign="top" align="justify" style="padding: 2em 0;">
                      <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">There has been a new submission to BMW Shorties 2017. Refer below. </span> <br><br>
                    </td>  
                  </tr>

                  <tr >
                    <td>
                      <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <td width="100%" valign="top" align="left">
                             <table cellpadding="0" cellspacing="0" width="100%">
                              <tr>  
                                <td width="260" valign="top" align="left">
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">Name: </span>
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">{{$data['name']}}</span> <br><br>
                                </td>  
                              </tr> 

                              <tr>  
                                <td width="260" valign="top" align="left">
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">Shortfilm Name: </span>
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">{{$data['title']}}</span> <br><br>
                                </td>  
                              </tr>

                              <tr>  
                                <td width="260" valign="top" align="left">
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">Email Address: </span>
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">{{$data['email']}}</span> <br><br>
                                </td>  
                              </tr>

                              <tr>  
                                <td width="260" valign="top" align="left">
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">Contact Number: </span>
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">{{$data['mobile-no']}}</span> <br><br>
                                </td>  
                              </tr>

                              <tr>  
                                <td width="260" valign="top" align="left">
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 700; font-size: 1em;">YouTube Link: </span>
                                  <span style="font-family: BMWTypeVTwo_Light;color: #000000; font-weight: 400; font-size: 1em;">{{$data['youtube']}}</span> <br><br>
                                </td>  
                              </tr>

                              <tr>
                                <td width="260" valign="top" align="left">
                                  <a href="{{url('contest-details')}}/{{$data['id']}}" target="_blank" style=" width: 50%; background: #29a3da; color: #fff; text-decoration: none; padding: .8em 0em; display: block; margin: 2em 0; text-align: center; font-weight: 400; font-size: 1em; font-family: BMWTypeVTwo_Light; ">View Details</a>
                                </td>  
                              </tr>
                              
                            </table> 
                          </td>  
                        </tr>
                      </table>
                    </td>
                  </tr>

                 <!--  <tr>
                    <td width="260" valign="top" align="left">
                      <a href="#" target="_blank" style="    width: 50%; background: #29a3da; color: #fff; text-decoration: none; padding: .8em 0em; display: block; margin: 2em 0; text-align: center; font-weight: 400; font-size: 1em; font-family: BMWTypeVTwo_Light; ">View Details</a>
                    </td>  
                  </tr> -->
 

                  <tr>
                    <td width="260" valign="top" align="justify">
                      <a href="http://www.bmwshorties.com.my/"><img src="{{url('img/bmw/logo-gray-08.png')}}"  style="display: block;width: 50%; margin-top: 2em; margin-bottom: 2em;" alt="The BMW Shorties">  </a>
                    </td>  
                  </tr>

                </table> 
              </td>  
            </tr> 
          </table>
        </td>
      </tr>
 
    </table>
  </body>
</html>
 