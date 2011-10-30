# PHP on Google App Engine

Blank PHP Google App for simple demonstration and deployment test.

PHP on Google App Engine Even after several years of public requests for opening App Engine ports for PHP programmers Google hasn't done much for it. But as well as Ruby is working on App Engine with Java, so is PHP possible using Caucho's Quercus Java implementation. Combining AppEngine and Quercus is little tricky at the moment. Information is spread all over the net and often is not using the latest packages. Thats why you may find next easy steps welcome.

## Components needed

* Java Development Kit (1.6)
* Google Application Engine Software Development Kit (1.5.5)
* Quercus & Resin Java-PHP5 bridge by Caucho (4.0.18)

## Downloads

1. Download JDK6 if you don't have it. Apple has its own fork of JDK for MacOS X and version 6 is already on basic operating system installation. For earlier versions you get the most recent help from Google.
2. Download custom PHP on Google App Engine installation package. Unzip to some place on your computer.

You can get all components on package separately, but if you want easy way, I recommend downloading custom installation package for hassle free deployment. In case you want to make your own setup, its all here:

* Download AppEngine. Choose Java version instead of Python version.
* Download Quercus. Get the latest war or source.
* See some instruction from this blog to make them work together.

## Configure & Deploy

With JDK6 you need to follow their install instructions. Most probably you will have JDK already installed on your computer. Then follow these steps:

1. Create your application on Google: http://appengine.google.com/. Take the name of the application for the next steps.
2. Get PHP on Google App Engine and upzip if you didn't already
3. Open ./war/appengine-web.xml file from unzipped directory and edit 3rd line:

   <application>my-application-id</application>

  to contain your application id.
4. Open console and go to the unzipped directory called "blankapp":

    cd /path/to/blankapp/ 

5. Run the deployment code for mac/linux:

    sh ./appengine-java-sdk-1.5.5/bin/appcfg.sh --enable_jar_splitting update ./war

    or run the deployment code for windows:

	./appengine-java-sdk-1.5.5/bin/appcfg.cmd --enable_jar_splitting update ./war

6. Give your Google account username and password.
7. Point your browser to your application root:

    http://my-application-id.appspot.com/

And that's it! See working example from: http://blankapp.appspot.com and notice the content of phpinfo() as an evidence of successful operation. Of course now you want to create the greatest PHP application on planet using scaleable, robust and secure Google clouds. Please not that there are some major and lots of minor restriction on Google platform you cannot do. You probably need to test & test & test to know all the small quirks, but hey, that is programmer's life! Happy learning and coding!

Package originally distributed on: http://php-apps.appspot.com/

You can also download package with Google App Engine SDK included from: http://budurl.com/phpongoogleappengine