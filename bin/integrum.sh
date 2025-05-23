#! /bin/sh

#
# Copyright (c) 1999, 2016 Tanuki Software, Ltd.
# http://www.tanukisoftware.com
# All rights reserved.
#
# This software is the proprietary information of Tanuki Software.
# You shall use it only in accordance with the terms of the
# license agreement you entered into with Tanuki Software.
# http://wrapper.tanukisoftware.com/doc/english/licenseOverview.html
#
# Java Service Wrapper sh script.  Suitable for starting and stopping
#  wrapped Java applications on UNIX platforms.
#

#-----------------------------------------------------------------------------
# These settings can be modified to fit the needs of your application
# Optimized for use with version 3.5.30 of the Wrapper.

# IMPORTANT - Please always stop and uninstall an application before making
#             any changes to this file.  Failure to do so could remove the
#             script's ability to control the application.

# Initialization block for the install_initd and remove_initd scripts used by
#  SUSE linux, CentOS and RHEL distributions.
# Note: From CentOS 6, make sure the BEGIN INIT INFO section is before any line 
#       of code otherwise the service won't be displayed in the Service 
#       Configuration GUI.
### BEGIN INIT INFO
# Provides: testwrapper
# Required-Start: $local_fs $network $syslog
# Should-Start: 
# Required-Stop:
# Default-Start: 2 3 4 5
# Default-Stop: 0 1 6
# Short-Description: Serwer Satel INTEGRUM
# Description: Serwer komunikacji Satel INTEGRUM
### END INIT INFO

# Application
APP_NAME="integrum-server"
APP_LONG_NAME="Serwer do komunikacji z centralami Satel Integra"

# If uncommented (and set to false), APP_NAME and APP_LONG_NAME will no longer 
# be passed to the wrapper. See documentation for details.
#APP_NAME_PASS_TO_WRAPPER=false

# Wrapper
WRAPPER_CMD="./wrapper"
WRAPPER_CONF="../conf/wrapper.conf"

# Priority at which to run the wrapper.  See "man nice" for valid priorities.
#  nice is only used if a priority is specified.
PRIORITY=

# Location of the pid file.
PIDDIR="."

# PIDFILE_CHECK_PID tells the script to double check whether the pid in the pid
#  file actually exists and belongs to this application.  When not set, only
#  check the pid, but not what it is.  This is only needed when multiple
#  applications need to share the same pid file.
PIDFILE_CHECK_PID=true

# FIXED_COMMAND tells the script to use a hard coded action rather than
# expecting the first parameter of the command line to be the command.
# By default the command will will be expected to be the first parameter.
#FIXED_COMMAND=console

# PASS_THROUGH tells the script to pass all arguments through to the JVM
#  as is.  If FIXED_COMMAND is specified then all arguments will be passed.
#  If not set then all arguments starting with the second will be passed.
#PASS_THROUGH=true

# If uncommented, causes the Wrapper to be shutdown using an anchor file.
#  When launched with the 'start' command, it will also ignore all INT and
#  TERM signals.
#IGNORE_SIGNALS=true

# Wrapper will start the JVM asynchronously. Your application may have some
#  initialization tasks and it may be desirable to wait a few seconds
#  before returning.  For example, to delay the invocation of following
#  startup scripts.  Setting WAIT_AFTER_STARTUP to a positive number will
#  cause the start command to delay for the indicated period of time 
#  (in seconds).
# 
WAIT_AFTER_STARTUP=0

# If set, wait for the wrapper to report that the daemon has started
WAIT_FOR_STARTED_STATUS=true
WAIT_FOR_STARTED_TIMEOUT=120

# If set, the status, start_msg and stop_msg commands will print out detailed
#   state information on the Wrapper and Java processes.
#DETAIL_STATUS=true

# If set, the 'pause' and 'resume' commands will be enabled.  These make it
#  possible to pause the JVM or Java application without completely stopping
#  the Wrapper.  See the wrapper.pausable and wrapper.pausable.stop_jvm
#  properties for more information.
#PAUSABLE=true

# If specified, the Wrapper will be run as the specified user.
# IMPORTANT - Make sure that the user has the required privileges to write
#  the PID file and wrapper.log files.  Failure to be able to write the log
#  file will cause the Wrapper to exit without any way to write out an error
#  message.
# NOTE - This will set the user which is used to run the Wrapper as well as
#  the JVM and is not useful in situations where a privileged resource or
#  port needs to be allocated prior to the user being changed.
RUN_AS_USER=wildfly

# Set the full path to the 'su' command (substitute user).
# NOTE - In case 'su' is not in the PATH, you can set the absolute path here,
#  for example:
#  SU_BIN=/bin/su
# NOTE - For Red Hat, the script will use '/sbin/runuser' if it is present and 
#  ignore the value of SU_BIN.
SU_BIN=su

# Set option for 'su'.
# In case the user set in RUN_AS_USER has no bash set, the 'su' command will fail.
# The workaround for GNU/Linux system is to specify which bash to use with 
#  the '-s' option.
#SU_OPTS="-s /bin/bash"

# Set the full path to the 'id' command.
# For example:
#  ID_BIN=/usr/bin/id
ID_BIN=id

# By default we show a detailed usage block.  Uncomment to show brief usage.
#BRIEF_USAGE=true

# OS service management tool: flag for using Upstart when installing (rather than init.d rc.d).
USE_UPSTART=

# OS service management tool: flag for using systemd when installing.
USE_SYSTEMD=1

# Flag for AIX to start/stop the Wrapper without using the System Resource 
# Controller (SRC).This is useful when you want to start the Wrapper as a 
# daemon without installation or when APP_NAME is longer than 14 chars. 
SKIP_SRC=

# When installing on Mac OSX platforms, the following domain will be used to
#  prefix the plist file name.
PLIST_DOMAIN=org.tanukisoftware.wrapper

# When installing on Mac OSX platforms, this parameter controls whether the daemon
# is to be kept continuously running or to let demand and conditions control the 
# invocation.
MACOSX_KEEP_RUNNING="false"

# The following two lines are used by the chkconfig command. Change as is
#  appropriate for your application.  They should remain commented.
# chkconfig: 2345 20 88
# description: Serwer komunikacji Satel INTEGRUM

# Set run level to use when installing the application to start and stop on
#  system startup and shutdown.  It is important that the application always
#  be uninstalled before making any changes to the run levels.
# It is also possible to specify different run levels based on the individual
#  platform.  When doing so this script will look for defined run levels in
#  the following order:
#   1) "RUN_LEVEL_S_$DIST_OS" or "RUN_LEVEL_K_$DIST_OS", where "$DIST_OS" is
#      the value of DIST_OS.  "RUN_LEVEL_S_solaris=20" for example.
#   2) RUN_LEVEL_S or RUN_LEVEL_K, to specify specify start or stop run levels.
#   3) RUN_LEVEL, to specify a general run level.
RUN_LEVEL=20

# List of files to source prior to executing any commands. Use ';' as delimiter.
# For example: 
#  FILES_TO_SOURCE="/home/user/.bashrc;anotherfile;../file3"
FILES_TO_SOURCE=

# Do not modify anything beyond this point
#-----------------------------------------------------------------------------

# check if we are running under Cygwin terminal.
# Note: on some OS's (for example Solaris, MacOS), -o is not a valid parameter 
# and it shows an error message. We redirect stderr to null so the error message
# doesn't show up.
CYGWIN=`uname -o 2>/dev/null`
if [ "$CYGWIN" = "Cygwin" ]
then
  eval echo `gettext 'This script is not compatible with Cygwin.  Please use the Wrapper batch files to control the Wrapper.'`
  exit 1
fi

if [ -n "$FIXED_COMMAND" ]
then
    COMMAND="$FIXED_COMMAND"
else
    COMMAND="$1"
fi

# check if there is a parameter "sysd"
SYSD=
if [ $# -gt 1 ] ; then
    if [ $2 = "sysd" ] ; then
        SYSD=1
    fi
fi

# default location for the service file
SYSTEMD_SERVICE_FILE="/etc/systemd/system/$APP_NAME.service"

# Required for HP-UX Startup
if [ `uname -s` = "HP-UX" -o `uname -s` = "HP-UX64" ] ; then
        PATH=$PATH:/usr/bin
fi

# Get the fully qualified path to the script
case $0 in
    /*)
        SCRIPT="$0"
        ;;
    *)
        PWD=`pwd`
        SCRIPT="$PWD/$0"
        ;;
esac

# Resolve the true real path without any sym links.
CHANGED=true
while [ "X$CHANGED" != "X" ]
do
    # Change spaces to ":" so the tokens can be parsed.
    SAFESCRIPT=`echo $SCRIPT | sed -e 's; ;:;g'`
    # Get the real path to this script, resolving any symbolic links
    TOKENS=`echo $SAFESCRIPT | sed -e 's;/; ;g'`
    REALPATH=
    for C in $TOKENS; do
        # Change any ":" in the token back to a space.
        C=`echo $C | sed -e 's;:; ;g'`
        REALPATH="$REALPATH/$C"
        # If REALPATH is a sym link, resolve it.  Loop for nested links.
        while [ -h "$REALPATH" ] ; do
            LS="`ls -ld "$REALPATH"`"
            LINK="`expr "$LS" : '.*-> \(.*\)$'`"
            if expr "$LINK" : '/.*' > /dev/null; then
                # LINK is absolute.
                REALPATH="$LINK"
            else
                # LINK is relative.
                REALPATH="`dirname "$REALPATH"`""/$LINK"
            fi
        done
    done

    if [ "$REALPATH" = "$SCRIPT" ]
    then
        CHANGED=""
    else
        SCRIPT="$REALPATH"
    fi
done

# Get the location of the script.
REALDIR=`dirname "$REALPATH"`
# Normalize the path
REALDIR=`cd "${REALDIR}"; pwd`

# If the PIDDIR is relative, set its value relative to the full REALPATH to avoid problems if
#  the working directory is later changed.
FIRST_CHAR=`echo $PIDDIR | cut -c1,1`
if [ "$FIRST_CHAR" != "/" ]
then
    PIDDIR=$REALDIR/$PIDDIR
fi
# Same test for WRAPPER_CMD
FIRST_CHAR=`echo $WRAPPER_CMD | cut -c1,1`
if [ "$FIRST_CHAR" != "/" ]
then
    WRAPPER_CMD=$REALDIR/$WRAPPER_CMD
fi
# Same test for WRAPPER_CONF
FIRST_CHAR=`echo $WRAPPER_CONF | cut -c1,1`
if [ "$FIRST_CHAR" != "/" ]
then
    WRAPPER_CONF=$REALDIR/$WRAPPER_CONF
fi

# Process ID
ANCHORFILE="$PIDDIR/$APP_NAME.anchor"
COMMANDFILE="$PIDDIR/$APP_NAME.command"
STATUSFILE="$PIDDIR/$APP_NAME.status"
JAVASTATUSFILE="$PIDDIR/$APP_NAME.java.status"
PIDFILE="$PIDDIR/$APP_NAME.pid"
LOCKDIR="/var/lock/subsys"
LOCKFILE="$LOCKDIR/$APP_NAME"
pid=""

# Install status
installedStatus=0 # 0: not installed
                  # 1: installed (default)
                  # 2: installed with systemd
                  # 3: installed with upstart
                  # 4: installed with SRC (complete: both lssrc & lsitab returned a record)
                  # 5: installed with SRC (partial: lssrc xor lsitab returned a record)
installedWith=""

# Resolve the location of the 'ps' command
PS_BIN="/usr/ucb/ps"
    if [ ! -x "$PS_BIN" ]
    then
        PS_BIN="/usr/bin/ps"
        if [ ! -x "$PS_BIN" ]
        then
            PS_BIN="/bin/ps"
            if [ ! -x "$PS_BIN" ]
            then
                eval echo `gettext 'Unable to locate "ps".'`
                eval echo `gettext 'Please report this message along with the location of the command on your system.'`
                exit 1
            fi
        fi
    fi

TR_BIN="/usr/bin/tr"
if [ ! -x "$TR_BIN" ]
then
    TR_BIN="/bin/tr"
    if [ ! -x "$TR_BIN" ]
    then
        eval echo `gettext 'Unable to locate "tr".'`
        eval echo `gettext 'Please report this message along with the location of the command on your system.'`
        exit 1
    fi
fi
# Resolve the os
DIST_OS=`uname -s | $TR_BIN "[A-Z]" "[a-z]" | $TR_BIN -d ' '`
case "$DIST_OS" in
    'sunos')
        DIST_OS="solaris"
        ;;
    'hp-ux' | 'hp-ux64')
        # HP-UX needs the XPG4 version of ps (for -o args)
        DIST_OS="hpux"
        UNIX95=""
        export UNIX95   
        ;;
    'darwin')
        DIST_OS="macosx"
        ;;
    'unix_sv')
        DIST_OS="unixware"
        ;;
    'os/390')
        DIST_OS="zos"
        ;;
esac

# Compare Versions $1<$2=0, $1==$2=1, $1>$2=2
compareVersions () {
    if [ "$1" = "$2" ]
    then
        return 1
    else
        local i=1
        while true
        do
            local v1=`echo "$1" | cut -d '.' -f $i`
            local v2=`echo "$2" | cut -d '.' -f $i`
            if [ "X$v1" = "X" ]
            then
                if [ "X$v2" = "X" ]
                then
                    return 1
                fi
                v1="0"
            elif [ "X$v2" = "X" ]
            then
                v2="0"
            fi
            if [ $v1 -lt $v2 ]
            then
                return 0
            elif [ $v1 -gt $v2 ]
            then
                return 2
            fi
            i=`expr $i + 1`
        done
    fi
}

# Resolve the architecture
if [ "$DIST_OS" = "macosx" ]
then
    OS_VER=`sw_vers | grep 'ProductVersion:' | grep -o '[0-9]*\.[0-9]*\.[0-9]*\|[0-9]*\.[0-9]*'`
    DIST_ARCH="universal"
    compareVersions "$OS_VER" "10.5.0"
    if [[ $? < 1 ]]
    then
        DIST_BITS="32"
        KEY_KEEP_ALIVE="OnDemand"
    else
        # Note: "OnDemand" has been deprecated and replaced from Mac OS X 10.5 by "KeepAlive"
        KEY_KEEP_ALIVE="KeepAlive"
        
        if [ "X`/usr/sbin/sysctl -n hw.cpu64bit_capable`" = "X1" ]  
        then
            DIST_BITS="64"
        else
            DIST_BITS="32"
        fi
    fi
    APP_PLIST_BASE=${PLIST_DOMAIN}.${APP_NAME}
    APP_PLIST=${APP_PLIST_BASE}.plist
else
    if [ "$DIST_OS" = "linux" ]
    then
        DIST_ARCH=
    else
        DIST_ARCH=`uname -p 2>/dev/null | $TR_BIN "[A-Z]" "[a-z]" | $TR_BIN -d ' '`
    fi
    if [ "X$DIST_ARCH" = "X" ]
    then
        DIST_ARCH="unknown"
    fi
    if [ "$DIST_ARCH" = "unknown" ]
    then
        DIST_ARCH=`uname -m 2>/dev/null | $TR_BIN "[A-Z]" "[a-z]" | $TR_BIN -d ' '`
    fi
    case "$DIST_ARCH" in
        'athlon' | 'i386' | 'i486' | 'i586' | 'i686')
            DIST_ARCH="x86"
            if [ "${DIST_OS}" = "solaris" ] ; then
                DIST_BITS=`isainfo -b`
            else
                DIST_BITS="32"
            fi
            ;;
        'amd64' | 'x86_64')
            DIST_ARCH="x86"
            DIST_BITS="64"
            ;;
        'ia32')
            DIST_ARCH="ia"
            DIST_BITS="32"
            ;;
        'ia64' | 'ia64n' | 'ia64w')
            DIST_ARCH="ia"
            DIST_BITS="64"
            ;;
        'ip27')
            DIST_ARCH="mips"
            DIST_BITS="32"
            ;;
        'ppc64le')
            DIST_ARCH="ppcle"
            DIST_BITS="64"
            ;;
        'power' | 'powerpc' | 'power_pc' | 'ppc64')
            if [ "${DIST_ARCH}" = "ppc64" ] ; then
                DIST_BITS="64"
            else
                DIST_BITS="32"
            fi
            DIST_ARCH="ppcbe"
            
            if [ "${DIST_OS}" = "aix" ] ; then
                DIST_ARCH="ppc"
                if [ `getconf KERNEL_BITMODE` -eq 64 ]; then
                    DIST_BITS="64"
                else
                    DIST_BITS="32"
                fi
            fi
            ;;
        'pa_risc' | 'pa-risc')
            DIST_ARCH="parisc"
            if [ `getconf KERNEL_BITS` -eq 64 ]; then
                DIST_BITS="64"
            else
                DIST_BITS="32"
            fi    
            ;;
        'sun4u' | 'sparcv9' | 'sparc')
            DIST_ARCH="sparc"
            DIST_BITS=`isainfo -b`
            ;;
        '9000/800' | '9000/785')
            DIST_ARCH="parisc"
            if [ `getconf KERNEL_BITS` -eq 64 ]; then
                DIST_BITS="64"
            else
                DIST_BITS="32"
            fi
            ;;
        '2064' | '2066' | '2084' | '2086' | '2094' | '2096' | '2097' | '2098' | '2817')
            DIST_ARCH="390"
            DIST_BITS="64"
            ;;
        armv*)
            if [ -z "`readelf -A /proc/self/exe | grep Tag_ABI_VFP_args`" ] ; then 
                DIST_ARCH="armel"
                DIST_BITS="32"
            else 
                DIST_ARCH="armhf"
                DIST_BITS="32"
            fi
            ;;
    esac
fi

# OSX always places Java in the same location so we can reliably set JAVA_HOME
if [ "$DIST_OS" = "macosx" ]
then
    if [ -z "$JAVA_HOME" ]; then
        if [ -x /usr/libexec/java_home ]; then
            JAVA_HOME=`/usr/libexec/java_home`; export JAVA_HOME
        else
        JAVA_HOME="/Library/Java/Home"; export JAVA_HOME
    fi
fi
fi

# Test Echo
ECHOTEST=`echo -n "x"`
if [ "$ECHOTEST" = "x" ]
then
    ECHOOPT="-n "
    ECHOOPTC=""
else
    ECHOOPT=""
    ECHOOPTC="\c"
fi


gettext() {
    "$WRAPPER_CMD" --translate "$1" "$WRAPPER_CONF" 2>/dev/null
    if [ $? != 0 ] ; then 
        echo "$1"
    fi
}

outputFile() {
    if [ -f "$1" ]
    then
        eval echo `gettext '  $1  Found but not executable.'`;
    else
        echo "  $1"
    fi
}

# Decide on the wrapper binary to use.
# If the bits of the OS could be detected, we will try to look for the
#  binary with the correct bits value.  If it doesn't exist, fall back
#  and look for the 32-bit binary.  If that doesn't exist either then
#  look for the default.
WRAPPER_TEST_CMD=""
if [ -f "$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-$DIST_BITS" ]
then
    WRAPPER_TEST_CMD="$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-$DIST_BITS"
    if [ ! -x "$WRAPPER_TEST_CMD" ]
    then
        chmod +x "$WRAPPER_TEST_CMD" 2>/dev/null
    fi
    if [ -x "$WRAPPER_TEST_CMD" ]
    then 
        WRAPPER_CMD="$WRAPPER_TEST_CMD"
    else
        outputFile "$WRAPPER_TEST_CMD"
        WRAPPER_TEST_CMD=""
    fi
fi
if [ -f "$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-32" -a -z "$WRAPPER_TEST_CMD" ]
then
    WRAPPER_TEST_CMD="$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-32"
    if [ ! -x "$WRAPPER_TEST_CMD" ]
    then
        chmod +x "$WRAPPER_TEST_CMD" 2>/dev/null
    fi
    if [ -x "$WRAPPER_TEST_CMD" ]
    then 
        WRAPPER_CMD="$WRAPPER_TEST_CMD"
    else
        outputFile "$WRAPPER_TEST_CMD"
        WRAPPER_TEST_CMD=""
    fi
fi
if [ -f "$WRAPPER_CMD" -a -z "$WRAPPER_TEST_CMD" ]
then
    WRAPPER_TEST_CMD="$WRAPPER_CMD"
    if [ ! -x "$WRAPPER_TEST_CMD" ]
    then
        chmod +x "$WRAPPER_TEST_CMD" 2>/dev/null
    fi
    if [ -x "$WRAPPER_TEST_CMD" ]
    then 
        WRAPPER_CMD="$WRAPPER_TEST_CMD"
    else
        outputFile "$WRAPPER_TEST_CMD"
        WRAPPER_TEST_CMD=""
    fi
fi
if [ -z "$WRAPPER_TEST_CMD" ]
then
    eval echo `gettext 'Unable to locate any of the following binaries:'`
    outputFile "$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-$DIST_BITS"
    if [ ! "$DIST_BITS" = "32" ]
    then
        outputFile "$WRAPPER_CMD-$DIST_OS-$DIST_ARCH-32"
    fi
    outputFile "$WRAPPER_CMD"

    exit 1
fi


# Build the nice clause
if [ "X$PRIORITY" = "X" ]
then
    CMDNICE=""
else
    CMDNICE="nice -$PRIORITY"
fi

# Build the anchor file clause.
if [ "X$IGNORE_SIGNALS" = "X" ]
then
   ANCHORPROP=
   IGNOREPROP=
else
   ANCHORPROP=wrapper.anchorfile=\"$ANCHORFILE\"
   IGNOREPROP=wrapper.ignore_signals=TRUE
fi

# Build the status file clause.
if [ "X$DETAIL_STATUS$WAIT_FOR_STARTED_STATUS" = "X" ]
then
   STATUSPROP=
else
   STATUSPROP="wrapper.statusfile=\"$STATUSFILE\" wrapper.java.statusfile=\"$JAVASTATUSFILE\""
fi

# Build the command file clause.
if [ -n "$PAUSABLE" ]
then
   COMMANDPROP="wrapper.commandfile=\"$COMMANDFILE\" wrapper.pausable=TRUE"
else
   COMMANDPROP=
fi

if [ ! -n "$WAIT_FOR_STARTED_STATUS" ]
then
    WAIT_FOR_STARTED_STATUS=true
fi

if [ $WAIT_FOR_STARTED_STATUS = true ] ; then
    DETAIL_STATUS=true
fi


# Build the lock file clause.  Only create a lock file if the lock directory exists on this platform.
LOCKPROP=
if [ -d $LOCKDIR ]
then
    if [ -w $LOCKDIR ]
    then
        LOCKPROP=wrapper.lockfile=\"$LOCKFILE\"
    fi
fi

# Build app name clause
if [ ! -n "$APP_NAME_PASS_TO_WRAPPER" ]
then
    APP_NAME_PASS_TO_WRAPPER=true
fi
if [ $APP_NAME_PASS_TO_WRAPPER = false ]
then
   APPNAMEPROP=
else
   APPNAMEPROP="wrapper.name=\"$APP_NAME\" wrapper.displayname=\"$APP_LONG_NAME\""
fi

# Decide on run levels.
RUN_LEVEL_S_DIST_OS_TMP=`eval "echo \$\{RUN_LEVEL_S_${DIST_OS}\}"`
RUN_LEVEL_S_DIST_OS=`eval "echo ${RUN_LEVEL_S_DIST_OS_TMP}"`
if [ "X${RUN_LEVEL_S_DIST_OS}" != "X" ] ; then
    APP_RUN_LEVEL_S=${RUN_LEVEL_S_DIST_OS}
elif [ "X$RUN_LEVEL_S" != "X" ] ; then
    APP_RUN_LEVEL_S=$RUN_LEVEL_S
else
    APP_RUN_LEVEL_S=$RUN_LEVEL
fi
APP_RUN_LEVEL_S_CHECK=`echo "$APP_RUN_LEVEL_S" | sed "s/[(0-9)*]/0/g"`
if [ "X${APP_RUN_LEVEL_S_CHECK}" != "X00" ] ; then
    eval echo `gettext 'Run level \"${APP_RUN_LEVEL_S}\" must be numeric and have a length of two \(00-99\).'`
    exit 1;
fi
RUN_LEVEL_K_DIST_OS_TMP=`eval "echo \$\{RUN_LEVEL_K_${DIST_OS}\}"`
RUN_LEVEL_K_DIST_OS=`eval "echo ${RUN_LEVEL_K_DIST_OS_TMP}"`
if [ "X${RUN_LEVEL_K_DIST_OS}" != "X" ] ; then
    APP_RUN_LEVEL_K=${RUN_LEVEL_K_DIST_OS}
elif [ "X$RUN_LEVEL_K" != "X" ] ; then
    APP_RUN_LEVEL_K=$RUN_LEVEL_K
else
    APP_RUN_LEVEL_K=$RUN_LEVEL
fi
APP_RUN_LEVEL_K_CHECK=`echo "$APP_RUN_LEVEL_K" | sed "s/[(0-9)*]/0/g"`
if [ "X${APP_RUN_LEVEL_K_CHECK}" != "X00" ] ; then
    eval echo `gettext 'Run level \"${APP_RUN_LEVEL_K}\" must be numeric and have a length of two \(00-99\).'`
    exit 1;
fi

prepAdditionalParams() {
    ADDITIONAL_PARA=""
    if [ ! -n "$PASS_THROUGH" ]
    then
        PASS_THROUGH=false
    fi
    if [ $PASS_THROUGH = true ] ; then
        ADDITIONAL_PARA="--"
    while [ -n "$1" ] ; do
        ADDITIONAL_PARA="$ADDITIONAL_PARA \"$1\""
        shift
    done
    elif [ -n "$1" ] ; then
        eval echo `gettext "WARNING: Extra arguments will be ignored. Please run \'$0 help\' for usage."`
    fi
}

checkUser() {
    # $1 touchLock flag
    # $2.. [command] args

    # Check the configured user.  If necessary rerun this script as the desired user.
    if [ "X$RUN_AS_USER" != "X" ]
    then
        # Resolve the location of the 'id' command
        ID_BIN="/usr/xpg4/bin/id"
        if [ ! -x "$ID_BIN" ]
        then
            ID_BIN="/usr/bin/id"
            if [ ! -x "$ID_BIN" ]
            then
                eval echo `gettext 'Unable to locate "id".'`
                eval echo `gettext 'Please report this message along with the location of the command on your system.'`
                exit 1
            fi
        fi

        if [ "`$ID_BIN -u -n`" = "$RUN_AS_USER" ]
        then
            # Already running as the configured user.  Avoid password prompts by not calling su.
            RUN_AS_USER=""
        fi
    fi
    if [ "X$RUN_AS_USER" != "X" ]
    then
        if [ "`$ID_BIN -u -n "$RUN_AS_USER" 2>/dev/null`" != "$RUN_AS_USER" ]
        then
            eval echo `gettext 'User $RUN_AS_USER does not exist.'`
            exit 1
        fi

        # If LOCKPROP and $RUN_AS_USER are defined then the new user will most likely not be
        # able to create the lock file.  The Wrapper will be able to update this file once it
        # is created but will not be able to delete it on shutdown.  If $1 is set then
        # the lock file should be created for the current command
        if [ "X$LOCKPROP" != "X" ]
        then
            if [ "X$1" != "X" ]
            then
                # Resolve the primary group 
                RUN_AS_GROUP=`groups $RUN_AS_USER | awk '{print $3}' | tail -1`
                if [ "X$RUN_AS_GROUP" = "X" ]
                then
                    RUN_AS_GROUP=$RUN_AS_USER
                fi
                touch $LOCKFILE
                chown $RUN_AS_USER:$RUN_AS_GROUP $LOCKFILE
            fi
        fi

        # Still want to change users, recurse.  This means that the user will only be
        #  prompted for a password once. Variables shifted by 1
        shift

        # Wrap the parameters so they can be passed.
        ADDITIONAL_PARA=""
        while [ -n "$1" ] ; do
            if [ "$1" = 'installstart' ] ; then
                # At this point the service is already installed. When we will fork the process we only need to start the service.
                ADDITIONAL_PARA="$ADDITIONAL_PARA \"start\""
            else
            ADDITIONAL_PARA="$ADDITIONAL_PARA \"$1\""
            fi
            shift
        done

        # Use "runuser" if this exists.
        # runuser should be used on RedHat in preference to su.
        if test -f "/sbin/runuser"
        then
            /sbin/runuser - $RUN_AS_USER -c "\"$REALPATH\" $ADDITIONAL_PARA"
        else
            $SU_BIN - $RUN_AS_USER -c "\"$REALPATH\" $ADDITIONAL_PARA" $SU_OPTS
        fi
        RUN_AS_USER_EXITCODE=$?
        
        # we check if the previous command has failed
        if [ $RUN_AS_USER_EXITCODE -ne 0 ]
        then
             if [ $RUN_AS_USER_EXITCODE -eq 1 ]
             then
                 checkForkCommand
             else
                 eval echo `gettext 'Error executing the requested command with user \"$RUN_AS_USER\" \(error code $RUN_AS_USER_EXITCODE\).'`
                 echo ""
            fi
        fi
        
        # Now that we are the original user again, we may need to clean up the lock file.
        if [ "X$LOCKPROP" != "X" ]
        then
            getpid
            if [ "X$pid" = "X" ]
            then
                # Wrapper is not running so make sure the lock file is deleted.
                if [ -f "$LOCKFILE" ]
                then
                    rm "$LOCKFILE"
                fi
            fi
        fi

        exit $RUN_AS_USER_EXITCODE
    fi
}

# Try to fork by executing a simple command.
# With this function, we want to make sure we are able to fork.
checkForkCommand() {
    
    if test -f "/sbin/runuser"
    then
        /sbin/runuser - $RUN_AS_USER -c "ls \"$REALPATH\"" > /dev/null 2>&1 &
    else
        $SU_BIN - $RUN_AS_USER -c "ls \"$REALPATH\"" $SU_OPTS > /dev/null 2>&1 &
    fi
    CHECK_EXITCODE=$?
    
    if [ $CHECK_EXITCODE -ne 0 ]
    then
        # clearly a problem with forking
        eval echo `gettext 'Error: unable to create fork process.'`
        eval echo `gettext 'Advice:'`
        eval echo `gettext 'One possible cause of failure is when the user \(\"$RUN_AS_USER\"\) has no shell.'`
        eval echo `gettext 'In this case, two solutions are available by editing the script file:'`
        eval echo `gettext '1. Use \"SU_OPTS\" to set the shell for the user.'`
        eval echo `gettext '2. Use a OS service management tool (only available on some platforms).'`
        echo ""
    fi
}

getpid() {
    pid=""
    if [ -f "$PIDFILE" ]
    then
        if [ -r "$PIDFILE" ]
        then
            pid=`cat "$PIDFILE"`
            if [ "X$pid" != "X" ]
            then
                if [ "X$PIDFILE_CHECK_PID" != "X" ]
                then
                    # It is possible that 'a' process with the pid exists but that it is not the
                    #  correct process.  This can happen in a number of cases, but the most
                    #  common is during system startup after an unclean shutdown.
                    # The ps statement below looks for the specific wrapper command running as
                    #  the pid.  If it is not found then the pid file is considered to be stale.
                    case "$DIST_OS" in
                        'freebsd')
                            pidtest=`$PS_BIN -p $pid -o args | tail -1`
                            if [ "X$pidtest" = "XCOMMAND" ]
                            then 
                                pidtest=""
                            fi
                            ;;
                        'macosx')
                            pidtest=`$PS_BIN -ww -p $pid -o command | grep -F "$WRAPPER_CMD" | tail -1`
                            ;;
                        'solaris')
                            if [ -f "/usr/bin/pargs" ]
                            then
                                pidtest=`pargs $pid | fgrep "$WRAPPER_CMD" | tail -1`
                            else
                                case "$PS_BIN" in
                                    '/usr/ucb/ps')
                                        pidtest=`$PS_BIN -auxww $pid | fgrep "$WRAPPER_CMD" | tail -1`
                                        ;;
                                    '/usr/bin/ps')
                                        TRUNCATED_CMD=`$PS_BIN -o comm -p $pid | tail -1`
                                        COUNT=`echo $TRUNCATED_CMD | wc -m`
                                        COUNT=`echo ${COUNT}`
                                        COUNT=`expr $COUNT - 1`
                                        TRUNCATED_CMD=`echo $WRAPPER_CMD | cut -c1-$COUNT`
                                        pidtest=`$PS_BIN -o comm -p $pid | fgrep "$TRUNCATED_CMD" | tail -1`
                                        ;;
                                    '/bin/ps')
                                        TRUNCATED_CMD=`$PS_BIN -o comm -p $pid | tail -1`
                                        COUNT=`echo $TRUNCATED_CMD | wc -m`
                                        COUNT=`echo ${COUNT}`
                                        COUNT=`expr $COUNT - 1`
                                        TRUNCATED_CMD=`echo $WRAPPER_CMD | cut -c1-$COUNT`
                                        pidtest=`$PS_BIN -o comm -p $pid | fgrep "$TRUNCATED_CMD" | tail -1`
                                        ;;
                                    *)
                                        echo "Unsupported ps command $PS_BIN"
                                        exit 1
                                        ;;
                                esac
                            fi
                            ;;
                        'hpux')
                            pidtest=`$PS_BIN -p $pid -x -o args | grep -F "$WRAPPER_CMD" | tail -1`
                            ;;
                        'zos')
                            TRUNCATED_CMD=`$PS_BIN -p $pid -o args | tail -1`
                            COUNT=`echo $TRUNCATED_CMD | wc -m`
                            COUNT=`echo ${COUNT}`
                            COUNT=`expr $COUNT - 1`
                            TRUNCATED_CMD=`echo $WRAPPER_CMD | cut -c1-$COUNT`
                            pidtest=`$PS_BIN -p $pid -o args | grep -F "$TRUNCATED_CMD" | tail -1`
                            ;;
                        *)
                            pidtest=`$PS_BIN -p $pid -o args | grep -F "$WRAPPER_CMD" | tail -1`
                            ;;
                    esac
                else
                    # Check to see whether the pid exists as a running process, but in this mode, don't check what that pid is.
                    case "$DIST_OS" in
                        'solaris')
                            case "$PS_BIN" in
                                '/usr/ucb/ps')
                                    pidtest=`$PS_BIN $pid | grep "$pid" | awk '{print $1}' | tail -1`
                                    ;;
                                '/usr/bin/ps')
                                    pidtest=`$PS_BIN -p $pid -o pid | grep "$pid" | tail -1`
                                    ;;
                                '/bin/ps')
                                    pidtest=`$PS_BIN -p $pid -o pid | grep "$pid" | tail -1`
                                    ;;
                                *)
                                    echo "Unsupported ps command $PS_BIN"
                                    exit 1
                                    ;;
                            esac
                            ;;
                        *)
                            pidtest=`$PS_BIN -p $pid -o pid | grep "$pid" | tail -1`
                            ;;
                    esac
                fi

                if [ "X$pidtest" = "X" ]
                then
                    # This is a stale pid file.
                    rm -f "$PIDFILE"
                    eval echo `gettext 'Removed stale pid file: $PIDFILE'`
                    pid=""
                fi
            else
                # This is a empty pid file.
                rm -f "$PIDFILE"
                eval echo `gettext 'Removed stale/empty pid file: $PIDFILE'`
                pid=""                			
            fi
        else
            eval echo `gettext 'Cannot read $PIDFILE.'`
            exit 1
        fi
    fi
}

getstatus() {
    STATUS=
    if [ -f "$STATUSFILE" ]
    then
        if [ -r "$STATUSFILE" ]
        then
            STATUS=`cat "$STATUSFILE"`
        fi
    fi
    if [ "X$STATUS" = "X" ]
    then
        STATUS="Unknown"
    fi
    
    JAVASTATUS=
    if [ -f "$JAVASTATUSFILE" ]
    then
        if [ -r "$JAVASTATUSFILE" ]
        then
            JAVASTATUS=`cat "$JAVASTATUSFILE"`
        fi
    fi
    if [ "X$JAVASTATUS" = "X" ]
    then
        JAVASTATUS="Unknown"
    fi
}

testpid() {
    case "$DIST_OS" in
     'solaris')
        case "$PS_BIN" in
        '/usr/ucb/ps')
            pid=`$PS_BIN  $pid | grep $pid | grep -v grep | awk '{print $1}' | tail -1`
            ;;
        '/usr/bin/ps')
            pid=`$PS_BIN -p $pid | grep $pid | grep -v grep | awk '{print $1}' | tail -1`
            ;;
        '/bin/ps')
            pid=`$PS_BIN -p $pid | grep $pid | grep -v grep | awk '{print $1}' | tail -1`
            ;;
        *)
            echo "Unsupported ps command $PS_BIN"
            exit 1
            ;;
        esac
        ;;
    *)
        pid=`$PS_BIN -p $pid | grep $pid | grep -v grep | awk '{print $1}' | tail -1` 2>/dev/null
        ;;
    esac
    if [ "X$pid" = "X" ]
    then
        pid=""
    fi
}

launchdtrap() {
    stopit
    exit 
}

waitforwrapperstop() {
    getpid
    while [ "X$pid" != "X" ] ; do
        sleep 1
        getpid
    done
}

launchinternal() {
    getpid
    trap launchdtrap TERM 
    if [ "X$pid" = "X" ]
    then 
        prepAdditionalParams "$@"

        # The string passed to eval must handles spaces in paths correctly.
        COMMAND_LINE="$CMDNICE \"$WRAPPER_CMD\" \"$WRAPPER_CONF\" wrapper.syslog.ident=\"$APP_NAME\" wrapper.pidfile=\"$PIDFILE\" wrapper.daemonize=TRUE $APPNAMEPROP $ANCHORPROP $IGNOREPROP $STATUSPROP $COMMANDPROP $LOCKPROP wrapper.script.version=3.5.30 $ADDITIONAL_PARA"
        eval $COMMAND_LINE
    else
        eval echo `gettext '$APP_LONG_NAME is already running.'`
        exit 1
    fi
    # launchd expects that this script stay up and running so we need to do our own monitoring of the Wrapper process.
    if [ $WAIT_FOR_STARTED_STATUS = true ]
    then
        waitforwrapperstop
    fi
}

console() {
    eval echo `gettext 'Running $APP_LONG_NAME...'`
    getpid
    if [ "X$pid" = "X" ]
    then
        trap '' 3

        prepAdditionalParams "$@"

        # The string passed to eval must handles spaces in paths correctly.
        COMMAND_LINE="$CMDNICE \"$WRAPPER_CMD\" \"$WRAPPER_CONF\" wrapper.syslog.ident=\"$APP_NAME\" wrapper.pidfile=\"$PIDFILE\" $APPNAMEPROP $ANCHORPROP $STATUSPROP $COMMANDPROP $LOCKPROP wrapper.script.version=3.5.30 $ADDITIONAL_PARA"
        eval $COMMAND_LINE
    else
        eval echo `gettext '$APP_LONG_NAME is already running.'`
        exit 1
    fi
}

waitforjavastartup() {
    getstatus
    eval echo $ECHOOPT `gettext 'Waiting for $APP_LONG_NAME...$ECHOOPTC'` 
    
    # Wait until the timeout or we have something besides Unknown.
    counter=15
    while [ "$JAVASTATUS" = "Unknown" -a $counter -gt 0 -a -n "$JAVASTATUS" ] ; do
        echo $ECHOOPT".$ECHOOPTC"
        sleep 1
        getstatus
        counter=`expr $counter - 1`
    done
    
    if [ -n "$WAIT_FOR_STARTED_TIMEOUT" ] ; then 
        counter=$WAIT_FOR_STARTED_TIMEOUT
    else
        counter=120
    fi
    while [ "$JAVASTATUS" != "STARTED" -a "$JAVASTATUS" != "Unknown" -a $counter -gt 0 -a -n "$JAVASTATUS" ] ; do
        echo $ECHOOPT".$ECHOOPTC"
        sleep 1
        getstatus
        counter=`expr $counter - 1`
    done
    echo ""
}
 
startwait() {
    if [ $WAIT_FOR_STARTED_STATUS = true ]
    then
        waitforjavastartup
    fi
    # Sleep for a few seconds to allow for intialization if required 
    #  then test to make sure we're still running.
    #
    i=0
    while [ $i -lt $WAIT_AFTER_STARTUP ]
    do
        sleep 1
        echo $ECHOOPT".$ECHOOPTC"
        i=`expr $i + 1`
    done
    if [ $WAIT_AFTER_STARTUP -gt 0 -o $WAIT_FOR_STARTED_STATUS = true ]
    then
        getpid
        if [ "X$pid" = "X" ]
        then
            eval echo `gettext ' WARNING: $APP_LONG_NAME may have failed to start.'`
            exit 1
        else
            eval echo `gettext ' running: PID:$pid'`
        fi
    else 
        echo ""
    fi
}

mustBeRootOrExit() {
    if [ `id | sed 's/^uid=//;s/(.*$//'` != "0" ] ; then       
        eval echo `gettext 'Must be root to perform this action.'`
        exit 1
    fi
}


macosxstart() {
    # The daemon has been installed.
    eval echo `gettext 'Starting $APP_LONG_NAME.  Detected Mac OSX and installed launchd daemon.'`
    mustBeRootOrExit
    
    getpid
    if [ "X$pid" != "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is already running.'`
        exit 1
    fi
    
    # If the daemon was just installed, it may not be loaded.
    LOADED_PLIST=`launchctl list | grep ${APP_PLIST_BASE}`
    if [ "X${LOADED_PLIST}" = "X" ] ; then
        launchctl load /Library/LaunchDaemons/${APP_PLIST}
    fi
    # If launchd is set to run the daemon already at Load, we don't need to call start
    getpid
    if [ "X$pid" = "X" ] ; then
        launchctl start ${APP_PLIST_BASE}
    fi
    
    startwait
}

macosxStop() {
    # The daemon should be running.
    eval echo `gettext 'Stopping $APP_LONG_NAME...'`
    mustBeRootOrExit
    
    getpid
    if [ "X$pid" = "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is not running.'`
        exit 1
    else
        if [ "$MACOSX_KEEP_RUNNING" = "true" ] ; then
            echo ""
            eval echo `gettext 'Daemon is set to be kept continuously running and it will be automatically restarted.'`
            eval echo `gettext 'To stop the daemon you need to uninstall it.'`
            eval echo `gettext 'If you want to use the \"stop\" argument, you need to find MACOSX_KEEP_RUNNING'`
            eval echo `gettext 'at the beginning of the script file and set it to \"false\".'`
            echo ""
        fi
        launchctl stop ${APP_PLIST_BASE}
    fi
}

macosxRestart() {
    # The daemon should be running.
    eval echo `gettext 'Restarting $APP_LONG_NAME...'`
    mustBeRootOrExit
    
    getpid
    if [ "X$pid" = "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is not running.'`
        exit 1
    else
        if [ "$MACOSX_KEEP_RUNNING" = "true" ] ; then
            # by stopping it, launchd will automatically restart it
            launchctl stop ${APP_PLIST_BASE}
        else
            launchctl unload "/Library/LaunchDaemons/${APP_PLIST}"
            sleep 1
            launchctl load   "/Library/LaunchDaemons/${APP_PLIST}"
        fi
    fi
    
    startwait
}

upstartstart() {
    # The daemon has been installed.
    eval echo `gettext 'Starting $APP_LONG_NAME.  Detected Linux and installed upstart.'`
    mustBeRootOrExit

    getpid
    if [ "X$pid" != "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is already running.'`
        exit 1
    fi
    
    /sbin/start ${APP_NAME}
        
    startwait
}

upstartStop() {
    # The daemon has been installed.
    eval echo `gettext 'Stopping $APP_LONG_NAME...'`
    mustBeRootOrExit
    
    getpid
    if [ "X$pid" = "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is not running.'`
        exit 1
    fi
    
    /sbin/stop ${APP_NAME}
}

upstartRestart() {
    # The daemon has been installed.
    eval echo `gettext 'Restarting $APP_LONG_NAME...'`
    mustBeRootOrExit
    
    getpid
    if [ "X$pid" = "X" ] ; then
        eval echo `gettext '$APP_LONG_NAME is not running.'`
        exit 1
    fi
    
    /sbin/restart ${APP_NAME}
        
    startwait
}

systemdInstall() {
    eval echo `gettext ' Installing the $APP_LONG_NAME daemon using systemd...'`
    if [ -f "${REALDIR}/${APP_NAME}.service" ] ; then 
        eval echo `gettext ' a custom service file ${APP_NAME}.service found'`
        cp "${REALDIR}/${APP_NAME}.service" "${SYSTEMD_SERVICE_FILE}"
    else
        eval echo `gettext ' creating default service file...'`
        echo "[Unit]"                            > "${SYSTEMD_SERVICE_FILE}"
        echo "Description=${APP_LONG_NAME}"     >> "${SYSTEMD_SERVICE_FILE}"
#        echo "After=syslog.target wildfly.service mnt-wibble.mount"              >> "${SYSTEMD_SERVICE_FILE}"
        echo "After=syslog.target wildfly.service"              >> "${SYSTEMD_SERVICE_FILE}"
        echo ""                                 >> "${SYSTEMD_SERVICE_FILE}"
        echo "[Service]"                        >> "${SYSTEMD_SERVICE_FILE}"
        echo "Type=forking"                     >> "${SYSTEMD_SERVICE_FILE}"
        echo "ExecStart=${REALPATH} start sysd" >> "${SYSTEMD_SERVICE_FILE}"
        echo "ExecStop=${REALPATH} stop sysd"   >> "${SYSTEMD_SERVICE_FILE}"
        if [ "X${RUN_AS_USER}" != "X" ] ; then
          echo "User=${RUN_AS_USER}"            >> "${SYSTEMD_SERVICE_FILE}"
        fi
        echo ""                                 >> "${SYSTEMD_SERVICE_FILE}"
        echo "[Install]"                        >> "${SYSTEMD_SERVICE_FILE}"
        echo "WantedBy=multi-user.target"       >> "${SYSTEMD_SERVICE_FILE}"

    fi
    systemctl daemon-reload
    systemctl enable "${APP_NAME}"
}

systemdStart() {
    # check if the service file is present
    if [ -f "${SYSTEMD_SERVICE_FILE}" ] ; then 
        eval echo `gettext 'Reading file ${SYSTEMD_SERVICE_FILE}'`
    else
        eval echo `gettext 'No service file detected. Did you install the service?'`
        exit 1
    fi

    systemctl start $APP_NAME
    if [ $? -ne 0 ] ; then
        eval echo `gettext 'Failed to start service $APP_NAME'`
        exit 1
    fi
    
    startwait
}

systemdStop() {
    systemctl stop $APP_NAME
    if [ $? -ne 0 ] ; then
        eval echo `gettext 'Failed to stop service $APP_NAME'`
        exit 1
    fi
}

systemdRestart() {
    systemctl restart $APP_NAME
    if [ $? -ne 0 ] ; then
        eval echo `gettext 'Failed to restart service $APP_NAME'`
        exit 1
    fi
    
    startwait
}

systemdRemove() {
    stopit "0"
    eval echo `gettext ' Removing $APP_LONG_NAME daemon from systemd...'`
    systemctl disable $APP_NAME
    rm "/etc/systemd/system/${APP_NAME}.service"
    systemctl daemon-reload
}

srcInstall() {
    if [ "X$RUN_AS_USER" = "X" ] ; then
        USERID="0"
    else
        USERID=`$ID_BIN -u "$RUN_AS_USER"`
        if [ $? -ne 0 ] ; then 
            eval echo `gettext 'Failed to get user id for $RUN_AS_USER'`
            exit 1
        fi
    fi
    /usr/bin/mkssys -s "$APP_NAME" -p "$REALPATH" -a "launchdinternal" -u "$USERID" -f 9 -n 15 -S
                /usr/sbin/mkitab "$APP_NAME":2:once:"/usr/bin/startsrc -s \"${APP_NAME}\" >/dev/console 2>&1"
    
    if [ -n "$SKIP_SRC" ] ; then
        eval echo `gettext 'Please do not set SKIP_SRC to be able to use SRC features.'`
    fi
}

srcStart() {
    startsrc -s "${APP_NAME}"
    if [ $? -ne 0 ] ; then
        eval echo `gettext 'Failed to start service $APP_NAME'`
        exit 1
    fi
    
    startwait
}

srcStop() {
    stopsrc -s "${APP_NAME}"
    if [ $? -ne 0 ] ; then
        eval echo `gettext 'Failed to stop service $APP_NAME'`
        exit 1
    fi
}

srcRestart() {
    srcStop
    srcStart
}

start() {
    eval echo `gettext 'Starting $APP_LONG_NAME...'`
    getpid
    if [ "X$pid" = "X" ]
    then
        prepAdditionalParams "$@"

        # The string passed to eval must handles spaces in paths correctly.
        COMMAND_LINE="$CMDNICE \"$WRAPPER_CMD\" \"$WRAPPER_CONF\" wrapper.syslog.ident=\"$APP_NAME\" wrapper.pidfile=\"$PIDFILE\" wrapper.daemonize=TRUE $APPNAMEPROP $ANCHORPROP $IGNOREPROP $STATUSPROP $COMMANDPROP $LOCKPROP wrapper.script.version=3.5.30 $ADDITIONAL_PARA"
        eval $COMMAND_LINE
    else
        eval echo `gettext '$APP_LONG_NAME is already running.'`
        exit 1
    fi
    
    startwait
}
 
stopit() {
    # $1 exit if down flag
    
    eval echo `gettext 'Stopping $APP_LONG_NAME...'`
    getpid
    if [ "X$pid" = "X" ]
    then
        eval echo `gettext '$APP_LONG_NAME was not running.'`
        if [ "X$1" = "X1" ]
        then
            exit 1
        fi
    else
        if [ "X$IGNORE_SIGNALS" = "X" ]
        then
            # Running so try to stop it.
            kill $pid
            if [ $? -ne 0 ]
            then
                # An explanation for the failure should have been given
                eval echo `gettext 'Unable to stop $APP_LONG_NAME.'`
                exit 1
            fi
        else
            rm -f "$ANCHORFILE"
            if [ -f "$ANCHORFILE" ]
            then
                # An explanation for the failure should have been given
                eval echo `gettext 'Unable to stop $APP_LONG_NAME.'`
                exit 1
            fi
        fi

        # We can not predict how long it will take for the wrapper to
        #  actually stop as it depends on settings in wrapper.conf.
        #  Loop until it does.
        savepid=$pid
        CNT=0
        TOTCNT=0
        while [ "X$pid" != "X" ]
        do
            # Show a waiting message every 5 seconds.
            if [ "$CNT" -lt "5" ]
            then
                CNT=`expr $CNT + 1`
            else
                eval echo `gettext 'Waiting for $APP_LONG_NAME to exit...'`
                CNT=0
            fi
            TOTCNT=`expr $TOTCNT + 1`

            sleep 1

            # Check if the process is still running.
            testpid
            
            if [ "X$pid" = "X" ]
                then
                # The process is gone, but it is possible that another instance restarted while we waited...
                SAVE_PIDFILE_CHECK_PID=$PIDFILE_CHECK_PID
                PIDFILE_CHECK_PID=""
                getpid
                PIDFILE_CHECK_PID=$SAVE_PIDFILE_CHECK_PID
                
                if [ "X$pid" != "X" ]
                then
                    # Another process is running.
                    if [ "$pid" = "$savepid" ]
                    then
                        # This should never happen, unless the PID was recycled?
                        eval echo `gettext 'Failed to stop $APP_LONG_NAME.'`
                        exit 1
                    else
                        eval echo `gettext 'The content of $PIDFILE has changed.'`
                        eval echo `gettext 'Another instance of the Wrapper might have started in the meantime.'`
                        
                        # Exit now. Any further actions might compromise the running instance.
                        exit 1
                    fi
                fi
            fi
        done

        eval echo `gettext 'Stopped $APP_LONG_NAME.'`
    fi
}
 
pause() {
    eval echo `gettext 'Pausing $APP_LONG_NAME.'`
}

resume() {
    eval echo `gettext 'Resuming $APP_LONG_NAME.'`
}

checkInstalled() {
    if [ "$DIST_OS" = "solaris" ] ; then
        if [ -f "/etc/init.d/$APP_NAME" -o -L "/etc/init.d/$APP_NAME" ] ; then
            installedStatus=1
        else
            installedStatus=0
        fi
    elif [ "$DIST_OS" = "linux" ] ; then
        if [ -f /etc/redhat-release -o -f /etc/redhat_version -o -f /etc/fedora-release ] ; then
            if [ -f "/etc/init.d/$APP_NAME" -o -L "/etc/init.d/$APP_NAME" ] ; then
                installedStatus=1
                installedWith="init.d"
            elif [ -n "$USE_SYSTEMD" -a -f "${SYSTEMD_SERVICE_FILE}" ] ; then
                installedStatus=2
                installedWith="systemd"
            elif [ -f "/etc/init/${APP_NAME}.conf" ] ; then
                installedStatus=3
                installedWith="upstart"
            else
                installedStatus=0
            fi
        elif [ -f /etc/SuSE-release ] ; then
            if [ -f "/etc/init.d/$APP_NAME" -o -L "/etc/init.d/$APP_NAME" ] ; then
                installedStatus=1
                installedWith="init.d"
            elif [ -n "$USE_SYSTEMD" -a -f "${SYSTEMD_SERVICE_FILE}" ] ; then
                installedStatus=2
                installedWith="systemd"
            else
                installedStatus=0
            fi
        elif [ -f /etc/lsb-release -o -f /etc/debian_version -o -f /etc/debian_release ] ; then
            if [ -f "/etc/init.d/$APP_NAME" -o -L "/etc/init.d/$APP_NAME" ] ; then
                installedStatus=1
                installedWith="init.d"
            elif [ -n "$USE_SYSTEMD" -a -f "${SYSTEMD_SERVICE_FILE}" ] ; then
                installedStatus=2
                installedWith="systemd"
            elif [ -f "/etc/init/${APP_NAME}.conf" ] ; then
                installedStatus=3
                installedWith="upstart"
            else
                installedStatus=0
            fi
        else
            if [ -f "/etc/init.d/$APP_NAME" -o -L "/etc/init.d/$APP_NAME" ] ; then
                installedStatus=1
            else
                installedStatus=0
            fi
        fi
    elif [ "$DIST_OS" = "hpux" ] ; then
        if [ -f "/sbin/init.d/$APP_NAME" -o -L "/sbin/init.d/$APP_NAME" ] ; then
            installedStatus=1
        else
            installedStatus=0
        fi
    elif [ "$DIST_OS" = "aix" ] ; then
        validateAppNameLength
        if [ -f "/etc/rc.d/init.d/$APP_NAME" -o -L "/etc/rc.d/init.d/$APP_NAME" ] ; then
            installedStatus=1
            installedWith="rc.d"
        elif [ -n "`/usr/sbin/lsitab $APP_NAME`" -a -n "`/usr/bin/lssrc -S -s $APP_NAME`" ] ; then
            installedStatus=4
            installedWith="SRC"
        elif [ -n "`/usr/sbin/lsitab $APP_NAME`" -o -n "`/usr/bin/lssrc -S -s $APP_NAME`" ] ; then
            installedStatus=5
            installedWith="SRC"
        else
            installedStatus=0
        fi
    elif [ "$DIST_OS" = "freebsd" ] ; then
            if [ -f "/etc/rc.d/$APP_NAME" -o -L "/etc/rc.d/$APP_NAME" ] ; then
            installedStatus=1
        else
            installedStatus=0
        fi
    elif [ "$DIST_OS" = "macosx" ] ; then
            if [ -f "/Library/LaunchDaemons/${APP_PLIST}" -o -L "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
            installedStatus=1
        else
            installedStatus=0
        fi
    elif [ "$DIST_OS" = "zos" ] ; then
            if [ -f /etc/rc.bak ] ; then
            installedStatus=1
        else
            installedStatus=0
        fi
    fi
}

status() {
    checkInstalled
    getpid
    if [ "X$pid" = "X" ]
    then
        if [ $installedStatus -eq 0 ] ; then
            eval echo `gettext '$APP_LONG_NAME \(not installed\) is not running.'`
        elif [ "X$installedWith" = "X" ] ; then
            eval echo `gettext '$APP_LONG_NAME \(installed\) is not running.'`
        else
            eval echo `gettext '$APP_LONG_NAME \(installed with $installedWith\) is not running.'`
        fi
        exit 1
    else
        if [ "X$DETAIL_STATUS" = "X" ]
        then
            if [ $installedStatus -eq 0 ] ; then
                eval echo `gettext '$APP_LONG_NAME \(not installed\) is running: PID:$pid'`
            elif [ "X$installedWith" = "X" ] ; then
                eval echo `gettext '$APP_LONG_NAME \(installed\) is running: PID:$pid'`
            else
                eval echo `gettext '$APP_LONG_NAME \(installed with $installedWith\) is running: PID:$pid'`
            fi
        else
            getstatus
            if [ $installedStatus -eq 0 ] ; then
                eval echo `gettext '$APP_LONG_NAME \(not installed\) is running: PID:$pid, Wrapper:$STATUS, Java:$JAVASTATUS'`
            elif [ "X$installedWith" = "X" ] ; then
                eval echo `gettext '$APP_LONG_NAME \(installed\) is running: PID:$pid, Wrapper:$STATUS, Java:$JAVASTATUS'`
            else
                eval echo `gettext '$APP_LONG_NAME \(installed with $installedWith\) is running: PID:$pid, Wrapper:$STATUS, Java:$JAVASTATUS'`
            fi
        fi
        exit 0
    fi
}

# Make sure APP_NAME is less than 14 characters, otherwise in AIX, the commands
# "lsitab" or "lssrc" will fail
validateAppNameLength() {
    if [ ${#APP_NAME} -gt 14 ] ; then
        eval echo `gettext ' APP_NAME must be less than 14 characters long. Length of ${APP_NAME} is ${#APP_NAME}.'`
        exit 1
    fi
}

installUpstart() {
    eval echo `gettext ' Installing the $APP_LONG_NAME daemon using upstart..'`
    if [ -f "${REALDIR}/${APP_NAME}.install" ] ; then 
        eval echo `gettext ' a custom upstart conf file ${APP_NAME}.install found'`
        cp "${REALDIR}/${APP_NAME}.install" "/etc/init/${APP_NAME}.conf"
    else
        eval echo `gettext ' creating default upstart conf file..'`
        echo "# ${APP_NAME} - ${APP_LONG_NAME}"                           > "/etc/init/${APP_NAME}.conf"
        echo "description \"${APP_LONG_NAME}\""                          >> "/etc/init/${APP_NAME}.conf"
        echo "author \"Tanuki Software Ltd. <info@tanukisoftware.com>\"" >> "/etc/init/${APP_NAME}.conf"
        echo "start on runlevel [2345]"                                  >> "/etc/init/${APP_NAME}.conf"
        echo "stop on runlevel [!2345]"                                  >> "/etc/init/${APP_NAME}.conf"
        echo "env LANG=${LANG}"                                          >> "/etc/init/${APP_NAME}.conf"
        echo "exec \"${REALPATH}\" upstartinternal"                      >> "/etc/init/${APP_NAME}.conf"
    fi
}

installdaemon() {
    mustBeRootOrExit
    
    checkInstalled
    APP_NAME_LOWER=`echo "$APP_NAME" | $TR_BIN "[A-Z]" "[a-z]"`
        if [ "$DIST_OS" = "solaris" ] ; then
            eval echo `gettext 'Detected Solaris:'`
        if [ $installedStatus -gt 0 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
            ln -s "$REALPATH" "/etc/init.d/$APP_NAME"
            for i in `ls "/etc/rc3.d/K"??"$APP_NAME_LOWER" "/etc/rc3.d/S"??"$APP_NAME_LOWER" 2>/dev/null` ; do
                eval echo `gettext ' Removing unexpected file before proceeding: $i'`
                rm -f $i
            done
            ln -s "/etc/init.d/$APP_NAME" "/etc/rc3.d/K${APP_RUN_LEVEL_K}$APP_NAME_LOWER"
            ln -s "/etc/init.d/$APP_NAME" "/etc/rc3.d/S${APP_RUN_LEVEL_S}$APP_NAME_LOWER"
            fi
        elif [ "$DIST_OS" = "linux" ] ; then
            if [ -f /etc/redhat-release -o -f /etc/redhat_version -o -f /etc/fedora-release ] ; then
                eval echo `gettext 'Detected RHEL or Fedora:'`
            if [ $installedStatus -gt 0 ] ; then
                eval echo `gettext ' The $APP_LONG_NAME daemon is already installed with $installedWith.'`
            elif [ -n "$USE_SYSTEMD" -a -d "/etc/systemd" ] ; then
                    systemdInstall
            else
                if [ -n "$USE_UPSTART" -a -d "/etc/init" ] ; then
                    installUpstart
                else 
                    eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
                    ln -s "$REALPATH" "/etc/init.d/$APP_NAME"
                    /sbin/chkconfig --add "$APP_NAME"
                    /sbin/chkconfig "$APP_NAME" on
                fi
                fi
            elif [ -f /etc/SuSE-release ] ; then
                eval echo `gettext 'Detected SuSE or SLES:'`
            if [ $installedStatus -gt 0 ] ; then
                eval echo `gettext ' The $APP_LONG_NAME daemon is already installed with $installedWith.'`
            elif [ -n "$USE_SYSTEMD" -a -d "/etc/systemd" ] ; then
                    systemdInstall
            else
                eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
                ln -s "$REALPATH" "/etc/init.d/$APP_NAME"
                insserv "/etc/init.d/$APP_NAME"
                fi
            elif [ -f /etc/lsb-release -o -f /etc/debian_version -o -f /etc/debian_release ] ; then
                eval echo `gettext 'Detected Ubuntu or Debian:'`
            if [ $installedStatus -gt 0 ] ; then
                eval echo `gettext ' The $APP_LONG_NAME daemon is already installed with $installedWith.'`
            else
                if [ -n "$USE_SYSTEMD" -a -d "/etc/systemd" ] ; then
                    systemdInstall
                elif [ -n "$USE_UPSTART" -a -d "/etc/init" ] ; then
                    installUpstart
                else 
                    eval echo `gettext ' Installing the $APP_LONG_NAME daemon using init.d..'`
                    ln -s "$REALPATH" "/etc/init.d/$APP_NAME"
                    update-rc.d "$APP_NAME" defaults
                fi
                fi
            else
                eval echo `gettext 'Detected Linux:'`
            if [ $installedStatus -gt 0 ] ; then
                eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
            else
                eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
                ln -s "$REALPATH" /etc/init.d/$APP_NAME
                for i in `ls "/etc/rc3.d/K"??"$APP_NAME_LOWER" "/etc/rc5.d/K"??"$APP_NAME_LOWER" "/etc/rc3.d/S"??"$APP_NAME_LOWER" "/etc/rc5.d/S"??"$APP_NAME_LOWER" 2>/dev/null` ; do
                    eval echo `gettext ' Removing unexpected file before proceeding: $i'`
                    rm -f $i
                done
                ln -s "/etc/init.d/$APP_NAME" "/etc/rc3.d/K${APP_RUN_LEVEL_K}$APP_NAME_LOWER"
                ln -s "/etc/init.d/$APP_NAME" "/etc/rc3.d/S${APP_RUN_LEVEL_S}$APP_NAME_LOWER"
                ln -s "/etc/init.d/$APP_NAME" "/etc/rc5.d/S${APP_RUN_LEVEL_S}$APP_NAME_LOWER"
                ln -s "/etc/init.d/$APP_NAME" "/etc/rc5.d/K${APP_RUN_LEVEL_K}$APP_NAME_LOWER"
                fi
            fi
        elif [ "$DIST_OS" = "hpux" ] ; then
            eval echo `gettext 'Detected HP-UX:'`
        if [ $installedStatus -gt 0 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
            ln -s "$REALPATH" "/sbin/init.d/$APP_NAME"
            for i in `ls "/sbin/rc3.d/K"??"$APP_NAME_LOWER" "/sbin/rc3.d/S"??"$APP_NAME_LOWER" 2>/dev/null` ; do
                eval echo `gettext ' Removing unexpected file before proceeding: $i'`
                rm -f $i
            done
            ln -s "/sbin/init.d/$APP_NAME" "/sbin/rc3.d/K${APP_RUN_LEVEL_K}$APP_NAME_LOWER"
            ln -s "/sbin/init.d/$APP_NAME" "/sbin/rc3.d/S${APP_RUN_LEVEL_S}$APP_NAME_LOWER"
            fi
        elif [ "$DIST_OS" = "aix" ] ; then
            eval echo `gettext 'Detected AIX:'`
            validateAppNameLength
        if [ $installedStatus -eq 1 -o $installedStatus -eq 4 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed with $installedWith.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
            if [ -n "`/usr/sbin/lsitab install_assist`" ] ; then 
                eval echo `gettext ' The task /usr/sbin/install_assist was found in the inittab, this might cause problems for all subsequent tasks to launch at this process is known to block the init task. Please make sure this task is not needed anymore and remove/deactivate it.'`
            fi
            for i in `ls "/etc/rc.d/rc2.d/K"??"$APP_NAME_LOWER" "/etc/rc.d/rc2.d/S"??"$APP_NAME_LOWER" 2>/dev/null` ; do
                eval echo `gettext ' Removing unexpected file before proceeding: $i'`
                rm -f $i
            done
            srcInstall
            fi
        elif [ "$DIST_OS" = "freebsd" ] ; then
            eval echo `gettext 'Detected FreeBSD:'`
        if [ $installedStatus -gt 0 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
                sed -i .bak "/${APP_NAME}_enable=\"YES\"/d" /etc/rc.conf
            if [ -f "${REALDIR}/${APP_NAME}.install" ] ; then
                ln -s "${REALDIR}/${APP_NAME}.install" "/etc/rc.d/$APP_NAME"
            else
                echo '#!/bin/sh'                    > "/etc/rc.d/$APP_NAME"
                echo "#"                           >> "/etc/rc.d/$APP_NAME"
                echo "# PROVIDE: $APP_NAME"        >> "/etc/rc.d/$APP_NAME"
                echo "# REQUIRE: NETWORKING"       >> "/etc/rc.d/$APP_NAME"
                echo "# KEYWORD: shutdown"         >> "/etc/rc.d/$APP_NAME"
                echo ". /etc/rc.subr"              >> "/etc/rc.d/$APP_NAME"
                echo "name=\"$APP_NAME\""          >> "/etc/rc.d/$APP_NAME"
                echo "rcvar=\`set_rcvar\`"         >> "/etc/rc.d/$APP_NAME"
                echo "command=\"${REALPATH}\""     >> "/etc/rc.d/$APP_NAME"
                echo 'start_cmd="${name}_start"'   >> "/etc/rc.d/$APP_NAME"
                echo 'load_rc_config $name'        >> "/etc/rc.d/$APP_NAME"
                echo 'status_cmd="${name}_status"' >> "/etc/rc.d/$APP_NAME"
                echo 'stop_cmd="${name}_stop"'     >> "/etc/rc.d/$APP_NAME"
                echo "${APP_NAME}_status() {"      >> "/etc/rc.d/$APP_NAME"
                echo '${command} status'           >> "/etc/rc.d/$APP_NAME"
                echo '}'                           >> "/etc/rc.d/$APP_NAME"
                echo "${APP_NAME}_stop() {"        >> "/etc/rc.d/$APP_NAME"
                echo '${command} stop'             >> "/etc/rc.d/$APP_NAME"
                echo '}'                           >> "/etc/rc.d/$APP_NAME"
                echo "${APP_NAME}_start() {"       >> "/etc/rc.d/$APP_NAME"
                echo '${command} start'            >> "/etc/rc.d/$APP_NAME"
                echo '}'                           >> "/etc/rc.d/$APP_NAME"
                echo 'run_rc_command "$1"'         >> "/etc/rc.d/$APP_NAME"
            fi
            echo "${APP_NAME}_enable=\"YES\"" >> /etc/rc.conf
            chmod 555 "/etc/rc.d/$APP_NAME"
            fi
        elif [ "$DIST_OS" = "macosx" ] ; then
            eval echo `gettext 'Detected Mac OSX:'`
        if [ $installedStatus -gt 0 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
            if [ -f "${REALDIR}/${APP_PLIST}" ] ; then
                ln -s "${REALDIR}/${APP_PLIST}" "/Library/LaunchDaemons/${APP_PLIST}"
            else
                echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"                       > "/Library/LaunchDaemons/${APP_PLIST}"
                echo "<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\"" >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "\"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">"             >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "<plist version=\"1.0\">"                                         >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "    <dict>"                                                      >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <key>Label</key>"                                        >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <string>${APP_PLIST_BASE}</string>"                      >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <key>ProgramArguments</key>"                             >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <array>"                                                 >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "            <string>${REALPATH}</string>"                        >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "            <string>launchdinternal</string>"                    >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        </array>"                                                >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <key>${KEY_KEEP_ALIVE}</key>"                            >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <${MACOSX_KEEP_RUNNING}/>"                               >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <key>RunAtLoad</key>"                                    >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "        <true/>"                                                 >> "/Library/LaunchDaemons/${APP_PLIST}"
                if [ "X$RUN_AS_USER" != "X" ] ; then
                    echo "        <key>UserName</key>"                                 >> "/Library/LaunchDaemons/${APP_PLIST}"
                    echo "        <string>${RUN_AS_USER}</string>"                     >> "/Library/LaunchDaemons/${APP_PLIST}"
                fi
                echo "    </dict>"                                                     >> "/Library/LaunchDaemons/${APP_PLIST}"
                echo "</plist>"                                                        >> "/Library/LaunchDaemons/${APP_PLIST}"
            fi
            chmod 555 "/Library/LaunchDaemons/${APP_PLIST}"
            fi
        elif [ "$DIST_OS" = "zos" ] ; then
            eval echo `gettext 'Detected z/OS:'`
        if [ $installedStatus -gt 0 ] ; then
            eval echo `gettext ' The $APP_LONG_NAME daemon is already installed.'`
        else
            eval echo `gettext ' Installing the $APP_LONG_NAME daemon..'`
                cp /etc/rc /etc/rc.bak
            sed  "s:echo /etc/rc script executed, \`date\`::g" /etc/rc.bak > /etc/rc
            echo "_BPX_JOBNAME='${APP_NAME}' \"${REALDIR}/${APP_NAME}\" start" >>/etc/rc
            echo '/etc/rc script executed, `date`' >>/etc/rc
        fi
    else
        eval echo `gettext 'Install not currently supported for $DIST_OS'`
        exit 1
    fi
    
    if [ $installedStatus -gt 0 -a "$COMMAND" != 'installstart' ] ; then
        exit 1
    fi
}

startdaemon() {
            if [ "$DIST_OS" = "macosx" -a -f "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
                macosxstart
            elif [ "$DIST_OS" = "linux" -a -f "/etc/init/${APP_NAME}.conf" ] ; then
                upstartstart
    elif [ "$DIST_OS" = "linux" -a -n "$USE_SYSTEMD" -a -z "$SYSD" ] ; then
        systemdStart
    elif [ "$DIST_OS" = "aix" -a -z "$SKIP_SRC" ] && [ -n "`/usr/bin/lssrc -S -s $APP_NAME`" ] ; then
        srcStart
    else
        if [ -n "$SYSD" ] ; then
            shift
        fi
        
        checkUser touchlock "$@"
        if [ ! -n "$FIXED_COMMAND" ] ; then
            shift
        fi
        start "$@"
    fi
}

removedaemon() {
    mustBeRootOrExit
    
    checkInstalled
    APP_NAME_LOWER=`echo "$APP_NAME" | $TR_BIN "[A-Z]" "[a-z]"`
    if [ "$DIST_OS" = "solaris" ] ; then
        eval echo `gettext 'Detected Solaris:'`
        if [ $installedStatus -eq 1 ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            for i in `ls "/etc/rc3.d/K"??"$APP_NAME_LOWER" "/etc/rc3.d/S"??"$APP_NAME_LOWER" "/etc/init.d/$APP_NAME" 2>/dev/null` ; do
                rm -f $i
            done
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    elif [ "$DIST_OS" = "linux" ] ; then
        if [ -f /etc/redhat-release -o -f /etc/redhat_version -o -f /etc/fedora-release ] ; then
            eval echo `gettext 'Detected RHEL or Fedora:'`
            if [ $installedStatus -eq 1 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
                /sbin/chkconfig "$APP_NAME" off
                /sbin/chkconfig --del "$APP_NAME"
                rm -f "/etc/init.d/$APP_NAME"
            elif [ $installedStatus -eq 2 ] ; then
                systemdRemove
            elif [ $installedStatus -eq 3 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon from upstart...'`
                rm "/etc/init/${APP_NAME}.conf"
            else
                eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
                exit 1
            fi
        elif [ -f /etc/SuSE-release ] ; then
            eval echo `gettext 'Detected SuSE or SLES:'`
            if [ $installedStatus -eq 1 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
                insserv -r "/etc/init.d/$APP_NAME"
                rm -f "/etc/init.d/$APP_NAME"
            elif [ $installedStatus -eq 2 ] ; then
                systemdRemove
            else
                eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
                exit 1
            fi
        elif [ -f /etc/lsb-release -o -f /etc/debian_version -o -f /etc/debian_release ] ; then
            eval echo `gettext 'Detected Ubuntu or Debian:'`
            if [ $installedStatus -eq 1 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon from init.d...'`
                update-rc.d -f "$APP_NAME" remove
                rm -f "/etc/init.d/$APP_NAME"
            elif [ $installedStatus -eq 2 ] ; then
                systemdRemove
            elif [ $installedStatus -eq 3 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon from upstart...'`
                rm "/etc/init/${APP_NAME}.conf"
            else
                eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
                exit 1
            fi
        else
            eval echo `gettext 'Detected Linux:'`
            if [ $installedStatus -eq 1 ] ; then
                stopit "0"
                eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
                for i in `ls "/etc/rc3.d/K"??"$APP_NAME_LOWER" "/etc/rc5.d/K"??"$APP_NAME_LOWER" "/etc/rc3.d/S"??"$APP_NAME_LOWER" "/etc/rc5.d/S"??"$APP_NAME_LOWER" "/etc/init.d/$APP_NAME" 2>/dev/null` ; do
                    rm -f $i
                done
            else
                eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
                exit 1
            fi
        fi
    elif [ "$DIST_OS" = "hpux" ] ; then
        eval echo `gettext 'Detected HP-UX:'`
        if [ $installedStatus -eq 1 ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            for i in `ls "/sbin/rc3.d/K"??"$APP_NAME_LOWER" "/sbin/rc3.d/S"??"$APP_NAME_LOWER" "/sbin/init.d/$APP_NAME" 2>/dev/null` ; do
                rm -f $i
            done
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    elif [ "$DIST_OS" = "aix" ] ; then
        eval echo `gettext 'Detected AIX:'`
        validateAppNameLength
        if [ $installedStatus -gt 0 ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            if [ $installedStatus -eq 1 ] ; then
                for i in `ls "/etc/rc.d/rc2.d/K"??"$APP_NAME_LOWER" "/etc/rc.d/rc2.d/S"??"$APP_NAME_LOWER" "/etc/rc.d/init.d/$APP_NAME" 2>/dev/null` ; do
                    rm -f $i
                done
            else
                /usr/sbin/rmitab $APP_NAME
                /usr/bin/rmssys -s $APP_NAME
            fi
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    elif [ "$DIST_OS" = "freebsd" ] ; then
        eval echo `gettext 'Detected FreeBSD:'`
        if [ -f "/etc/rc.d/$APP_NAME" -o -L "/etc/rc.d/$APP_NAME" ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            for i in "/etc/rc.d/$APP_NAME"
            do
                rm -f $i
            done
            sed -i .bak "/${APP_NAME}_enable=\"YES\"/d" /etc/rc.conf
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    elif [ "$DIST_OS" = "macosx" ] ; then
        eval echo `gettext 'Detected Mac OSX:'`
        if [ -f "/Library/LaunchDaemons/${APP_PLIST}" -o -L "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            # Make sure the plist is installed
            LOADED_PLIST=`launchctl list | grep ${APP_PLIST_BASE}`
            if [ "X${LOADED_PLIST}" != "X" ] ; then
                launchctl unload "/Library/LaunchDaemons/${APP_PLIST}"
            fi
            rm -f "/Library/LaunchDaemons/${APP_PLIST}"
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    elif [ "$DIST_OS" = "zos" ] ; then
        eval echo `gettext 'Detected z/OS:'`
        if [ -f /etc/rc.bak ] ; then
            stopit "0"
            eval echo `gettext ' Removing $APP_LONG_NAME daemon...'`
            cp /etc/rc /etc/rc.bak
            sed  "s/_BPX_JOBNAME=\'APP_NAME\'.*//g" /etc/rc.bak > /etc/rc
            rm /etc/rc.bak
        else
            eval echo `gettext ' The $APP_LONG_NAME daemon is not currently installed.'`
            exit 1
        fi
    else
        eval echo `gettext 'Remove not currently supported for $DIST_OS'`
        exit 1
    fi
}

dump() {
    eval echo `gettext 'Dumping $APP_LONG_NAME...'`
    getpid
    if [ "X$pid" = "X" ]
    then
        eval echo `gettext '$APP_LONG_NAME was not running.'`
    else
        kill -3 $pid

        if [ $? -ne 0 ]
        then
            eval echo `gettext 'Failed to dump $APP_LONG_NAME.'`
            exit 1
        else
            eval echo `gettext 'Dumped $APP_LONG_NAME.'`
        fi
    fi
}

# Used by HP-UX init scripts.
startmsg() {
    getpid
    if [ "X$pid" = "X" ]
    then
        eval echo `gettext 'Starting $APP_LONG_NAME...  Wrapper:Stopped'`
    else
        if [ "X$DETAIL_STATUS" = "X" ]
        then
            eval echo `gettext 'Starting $APP_LONG_NAME...  Wrapper:Running'`
        else
            getstatus
            eval echo `gettext 'Starting $APP_LONG_NAME...  Wrapper:$STATUS, Java:$JAVASTATUS'`
        fi
    fi
}

# Used by HP-UX init scripts.
stopmsg() {
    getpid
    if [ "X$pid" = "X" ]
    then
        eval echo `gettext 'Stopping $APP_LONG_NAME...  Wrapper:Stopped'`
    else
        if [ "X$DETAIL_STATUS" = "X" ]
        then
            eval echo `gettext 'Stopping $APP_LONG_NAME...  Wrapper:Running'`
        else
            getstatus
            eval echo `gettext 'Stopping $APP_LONG_NAME...  Wrapper:$STATUS, Java:$JAVASTATUS'`
        fi
    fi
}

# 'source' files
sourceFiles() {
    if [ -n "$FILES_TO_SOURCE" ] ; then
        OIFS=$IFS
        IFS=';'
        files=$FILES_TO_SOURCE
        for file in $files
        do
            . $file
        done

        IFS=$OIFS
    fi
}

showUsage() {
    # $1 bad command

    if [ -n "$1" ]
    then
        eval echo `gettext 'Unexpected command: $1'`
        echo "";
    fi

    eval MSG=`gettext 'Usage: '`
    if [ -n "$FIXED_COMMAND" ] ; then
        if [ -n "$PASS_THROUGH" ] ; then
            echo "${MSG} $0 {JavaAppArgs}"
        else
            echo "${MSG} $0"
        fi
    else
        if [ -n "$PAUSABLE" ] ; then
            if [ -n "$PASS_THROUGH" ] ; then
                echo "${MSG} $0 [ console {JavaAppArgs} | start {JavaAppArgs} | stop | restart {JavaAppArgs} | condrestart {JavaAppArgs} | pause | resume | status | install | installstart | remove | dump ]"
            else
                echo "${MSG} $0 [ console | start | stop | restart | condrestart | pause | resume | status | install | installstart | remove | dump ]"
            fi
        else
            if [ -n "$PASS_THROUGH" ] ; then
                echo "${MSG} $0 [ console {JavaAppArgs} | start {JavaAppArgs} | stop | restart {JavaAppArgs} | condrestart {JavaAppArgs} | status | install | installstart | remove | dump ]"
            else
                echo "${MSG} $0 [ console | start | stop | restart | condrestart | status | install | installstart | remove | dump ]"
            fi
        fi
    fi

    if [ ! -n "$BRIEF_USAGE" ]
    then
        echo "";
        if [ ! -n "$FIXED_COMMAND" ] ; then
            echo "`gettext 'Commands:'`"
            echo "`gettext '  console      Launch in the current console.'`"
            echo "`gettext '  start        Start in the background as a daemon process.'`"
            echo "`gettext '  stop         Stop if running as a daemon or in another console.'`"
            echo "`gettext '  restart      Stop if running and then start.'`"
            echo "`gettext '  condrestart  Restart only if already running.'`"
            if [ -n "$PAUSABLE" ] ; then
                echo "`gettext '  pause        Pause if running.'`"
                echo "`gettext '  resume       Resume if paused.'`"
            fi
            echo "`gettext '  status       Query the current status.'`"
            echo "`gettext '  install      Install to start automatically when system boots.'`"
            echo "`gettext '  installstart Install and start running as a daemon process.'`"
            echo "`gettext '  remove       Uninstall.'`"
            echo "`gettext '  dump         Request a Java thread dump if running.'`"
            echo "";
        fi
        if [ -n "$PASS_THROUGH" ] ; then
            echo "`gettext 'JavaAppArgs: Zero or more arguments which will be passed to the Java application.'`"
            echo "";
        fi
    fi

    exit 1
}

docommand() {
    case "$COMMAND" in
        'console')
            checkUser touchlock "$@"
            if [ ! -n "$FIXED_COMMAND" ] ; then
                shift
            fi
            console "$@"
            ;;
    
        'start')
            startdaemon "$@"
            ;;
    
        'stop')
            if [ "$DIST_OS" = "macosx" -a -f "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
                macosxStop
            elif [ "$DIST_OS" = "linux" -a -f "/etc/init/${APP_NAME}.conf" ] ; then
                upstartStop
            elif [ "$DIST_OS" = "linux" -a -n "$USE_SYSTEMD" -a -z "$SYSD" ] ; then
                systemdStop
            elif [ "$DIST_OS" = "aix" -a -z "$SKIP_SRC" ] && [ "`/usr/bin/lssrc -S -s $APP_NAME`" ] ; then
                srcStop
            else
                checkUser "" "$COMMAND"
                stopit "0"
            fi
            ;;
    
        'restart')
            if [ "$DIST_OS" = "macosx" -a -f "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
                macosxRestart
            elif [ "$DIST_OS" = "linux" -a -f "/etc/init/${APP_NAME}.conf" ] ; then
                upstartRestart
            elif [ "$DIST_OS" = "linux" -a -n "$USE_SYSTEMD" -a -z "$SYSD" ] ; then
                systemdRestart
            elif [ "$DIST_OS" = "aix" -a -z "$SKIP_SRC" ] && [ "`/usr/bin/lssrc -S -s $APP_NAME`" ] ; then
                srcRestart
            else
                if [ -n "$SMF" ] ; then
                    shift
                fi
            checkUser touchlock "$COMMAND"
            if [ ! -n "$FIXED_COMMAND" ] ; then
                shift
            fi
            stopit "0"
            start "$@"
            fi
            ;;
    
        'condrestart')
            checkUser touchlock "$COMMAND"
            if [ ! -n "$FIXED_COMMAND" ] ; then
                shift
            fi
            stopit "1"
            start "$@"
            ;;
    
        'pause')
            if [ -n "$PAUSABLE" ]
            then
                pause
            else
                showUsage "$COMMAND"
            fi
            ;;
    
        'resume')
            if [ -n "$PAUSABLE" ]
            then
                resume
            else
                showUsage "$COMMAND"
            fi
            ;;
    
        'status')
            status
            ;;
    
        'install')
            installdaemon "$@"
            ;;
    
        'installstart')
            installdaemon "$@"
            startdaemon "$@"
            ;;
    
        'remove')
            removedaemon
            ;;
    
        'dump')
            checkUser "" "$COMMAND"
            dump
            ;;
    
        'start_msg')
            # Internal command called by launchd on HP-UX.
            checkUser "" "$COMMAND"
            startmsg
            ;;
    
        'stop_msg')
            # Internal command called by launchd on HP-UX.
            checkUser "" "$COMMAND"
            stopmsg
            ;;
    
        'launchdinternal' | 'upstartinternal')
            if [ ! "$DIST_OS" = "macosx" -o ! -f "/Library/LaunchDaemons/${APP_PLIST}" ] ; then
                checkUser touchlock "$@"
            fi
            # Internal command called by launchd on Max OSX.
            # We do not want to call checkUser here as it is handled in the launchd plist file.  Doing it here would confuse launchd.
            if [ ! -n "$FIXED_COMMAND" ] ; then
                shift
            fi
            launchinternal "$@"
            ;;
    
        *)
            showUsage "$COMMAND"
            ;;
    esac
}

sourceFiles
docommand "$@"

exit 0
