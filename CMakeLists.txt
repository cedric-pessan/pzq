cmake_minimum_required(VERSION 2.6)

PROJECT(pzq)
SET(MODULE_NAME pzq)

SET(CMAKE_MODULE_PATH "${CMAKE_SOURCE_DIR}/cmake/" ${CMAKE_MODULE_PATH})
set(CMAKE_CXX_FLAGS "-g -Wall")

IF(${CMAKE_SYSTEM_NAME} MATCHES "Darwin")
	IF(EXISTS "/opt/local/var/macports/")
		LIST (APPEND CMAKE_PREFIX_PATH "/opt/local")
		LIST (APPEND CMAKE_LIBRARY_PATH "/opt/local/lib")
	ENDIF()
ELSEIF (WIN32)  
  SET(Boost_USE_STATIC_LIBS ON)
  SET(Boost_USE_STATIC_RUNTIME OFF)
ENDIF ()

FIND_PACKAGE(Boost COMPONENTS program_options thread system REQUIRED)
FIND_PACKAGE(ZeroMQ REQUIRED)
FIND_PACKAGE(kyotocabinet REQUIRED)
FIND_PACKAGE(Libuuid REQUIRED)

INCLUDE_DIRECTORIES(${Boost_INCLUDE_DIRS}) 
INCLUDE_DIRECTORIES(${ZeroMQ_INCLUDE_DIRS})
INCLUDE_DIRECTORIES(${kyotocabinet_INCLUDE_DIRS})
INCLUDE_DIRECTORIES(${libuuid_INCLUDE_DIRS})
INCLUDE_DIRECTORIES(src/)

LINK_DIRECTORIES(${Boost_LIBRARY_DIRS}) 
LINK_DIRECTORIES(${ZeroMQ_LIBRARY_DIRS})
LINK_DIRECTORIES(${kyotocabinet_LIBRARY_DIRS})
LINK_DIRECTORIES(${libuuid_LIBRARY_DIRS})

ADD_EXECUTABLE(${MODULE_NAME} src/main.cpp 
                              src/manager.cpp
			      src/store.cpp 
			      src/visitor.cpp 
			      src/reaper.cpp 
			      src/cluster.cpp
			      src/ackcache.cpp)
TARGET_LINK_LIBRARIES(${MODULE_NAME} ${Boost_LIBRARIES})
TARGET_LINK_LIBRARIES(${MODULE_NAME} ${ZeroMQ_LIBRARIES})
TARGET_LINK_LIBRARIES(${MODULE_NAME} ${kyotocabinet_LIBRARIES})
TARGET_LINK_LIBRARIES(${MODULE_NAME} ${libuuid_LIBRARIES})

IF(${CMAKE_SYSTEM_NAME} MATCHES "Linux")
  TARGET_LINK_LIBRARIES(${MODULE_NAME} uuid)
  TARGET_LINK_LIBRARIES(${MODULE_NAME} pthread)
ENDIF()

