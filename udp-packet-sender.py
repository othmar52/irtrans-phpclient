#!/usr/bin/env python
# -*- coding: utf-8 -*-


import optparse
import socket

if __name__=="__main__":
    #liste = ["start"]
    parser = optparse.OptionParser("usage: %prog [options] arg1 arg2")
    parser.add_option("-p", "--port", dest="portnum",
                      type="int", help="port number to connect", nargs=1)
    parser.add_option("-H", "--host", dest="host", default="localhost",
                      type="string", help="Host to connect to", nargs=1)
    (options, args) = parser.parse_args()
    portnum = options.portnum
    host = options.host
    s_args =  " ".join(args) + "\n"
    if options.portnum is None:
        parser.print_help()
        parser.error("-p PORT is required")
    socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    socket.connect((host, portnum))
    socket.sendall(s_args)
    response = socket.recv(8192)
    print "Received:", response
    socket.close()
